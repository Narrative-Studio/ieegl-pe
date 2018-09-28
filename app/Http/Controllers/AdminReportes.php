<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Yajra\DataTables\Facades\DataTables;


class AdminReportes extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $page;
    private $path;
    private $perPage = 25;

    /**
     * Reportes constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        ArangoException::enableLogging();
        $this->middleware('auth:admin');
    }

    /**
     *  Reporte Usuarios Emprendimientos
     */
    public function UsuariosEmprendimientos(){
        return view('admin.reportes.usuarios-emprendimientos');
    }

    /**
     * Reporte Usuarios Emprendimientos AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function UsuariosEmprendimientosAjax(Request $request){

        $search_txt = "";
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = trim($request->get('search'));
        $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
        $order = trim($request->get('order'));

        if($search!='') $search_txt = 'AND (LOWER(CONCAT(u.nombre," ",u.apellidos)) LIKE "%'.strtolower($search).'%" OR LOWER(u.email) LIKE "%'.strtolower($search).'%")';

        $data = $this->ArangoDB->Query("
            FOR u IN users 
                    FILTER u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.active==1 AND u.isAdmin==0 $search_txt
                    LIMIT $offset,$limit
                    SORT u.$sort $order
            RETURN {'id':u._key, 'nombre':CONCAT(u.nombre,' ',u.apellidos), 'email':u.email}", true);

        $data_total = $this->ArangoDB->Query("
            FOR u IN users 
                FILTER u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.active==1 AND u.isAdmin==0 $search_txt
                COLLECT WITH COUNT INTO length
            RETURN length", true);

        /*
        $data = $this->ArangoDB->Query("
            FOR u IN users
                FOR p IN perfiles
                        FILTER  u._key == p.userKey AND u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.active==1 AND u.isAdmin==0 $search_txt
                        LIMIT $offset,$limit
                        SORT u.$sort $order
            RETURN {
                    'id':u._key, 'nombre':CONCAT(u.nombre,' ',u.apellidos), 'email':u.email,
                    'fecha_nacimiento': p.fecha_nacimiento?f: '',
                    'biografia': p.biografia? : '',
                    'sexo': p.sexo? : '',
                    'a_que_se_dedica': p.a_que_se_dedica? : '',
                    'linkedin': p.linkedin? : '',
                    'pais': p.pais? : '',
                    'estado': p.estado? : '',
                    'estado_otro': p.estado_otro? : '',
                    'ciudad': p.ciudad? : '',
                    'universidad': p.universidad ? : '',
                    'actualmente_cursando_carrera': p.actualmente_cursando_carrera? : '',
                    'fecha_graduacion': p.fecha_graduacion? : '',
                    'matricula': p.matricula? : '',
                    'universidad_otra': p.universidad_otra ? : '',
                    'campus': p.campus ? : ''
                }", true);

        $data_total = $this->ArangoDB->Query("
            FOR u IN users
            FOR p IN perfiles
                    FILTER  u._key == p.userKey AND u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.active==1 AND u.isAdmin==0 $search_txt
                    COLLECT WITH COUNT INTO length
            RETURN length", true);
         */


        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $data;
        return json_encode($datos);
    }

    /**
     * Reporte Emprendimientos
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Emprendimientos(Request $request){
        return view('admin.reportes.emprendimientos');
    }

    /**
     * Reporte Emprendimientos AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function EmprendimientosAjax(Request $request){

        $search_txt = "";
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = trim($request->get('search'));
        $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
        $order = trim($request->get('order'));

        if($search!='') $search_txt = 'FILTER doc.nombre LIKE "%'.strtolower($search).'%"';

        $data = $this->ArangoDB->Query("
            FOR doc IN emprendimientos 
                $search_txt
                LIMIT $offset,$limit
                SORT doc.$sort $order
            RETURN {
                'id': doc._key, 
                'nombre': doc.nombre, 
                'descripcion': doc.descripcion?:'',
                'numero_colaboradores': doc.numero_colaboradores?:'',
                'pais': doc.pais?:'',
                'ciudad': doc.ciudad?:'',
                'industria_o_sector': doc.industria_o_sector? (FOR u IN industrias FILTER u._key IN (doc.industria_o_sector) RETURN u.nombre):'',
                'etapa_emprendimiento': doc.etapa_emprendimiento? (FOR u IN etapas FILTER u._key == doc.etapa_emprendimiento RETURN u.nombre):'',
                'mercado_cliente': doc.mercado_cliente?:'',
                'problema_soluciona': doc.problema_soluciona?:'',
                'competencia': doc.competencia?:'',
                'diferencia_competencia': doc.diferencia_competencia?:'',
                'diferenciador_modelo_negocio': doc.diferenciador_modelo_negocio?:'',
                'prototipo_o_mvp': doc.prototipo_o_mvp?:'',
                'investigacion_desarrollo': doc.investigacion_desarrollo?:'',
                'numero_socios': doc.numero_socios?:'',
                'nivel_tlr': doc.nivel_tlr?:'',
                'socios': doc.socios? (FOR u IN users FILTER u._key IN (doc.socios) RETURN CONCAT(u.nombre,' ',u.apellidos)):'',
                'como_te_enteraste': doc.como_te_enteraste?:'',
                'sitio_web': doc.sitio_web?:'',
                'red_social': doc.red_social?:'',
                'video': doc.video?:'',
                'tiene_clientes': doc.tiene_clientes?:'',
                'caracteristicas_clientes': doc.caracteristicas_clientes?:'',
                'clientes_activos': doc.clientes_activos?:'',
                'clientes': doc.clientes?:'',
                'tiene_usuarios': doc.tiene_usuarios?:'',
                'caracteristicas_usuarios': doc.caracteristicas_usuarios?:'',
                'usuarios_activos': doc.usuarios_activos?:'',
                'usuarios': doc.usuarios?:'',           
                'socios_operadores': doc.socios_operadores?:'',
                'capital': doc.capital?:'',
                'levantado_capital': doc.levantado_capital?:'',
                'recibido_inversion': doc.recibido_inversion?:'',
                'recibido_inversion_dequien': doc.recibido_inversion_dequien?:'',
                'recibido_inversion_cuanto': doc.recibido_inversion_cuanto?:'',
                'recibido_inversion_como': doc.recibido_inversion_como?:'',
                'recibido_inversion_fecha_levantaron_capital': doc.recibido_inversion_fecha_levantaron_capital?DATE_FORMAT(doc.recibido_inversion_fecha_levantaron_capital, '%dd/%mm/%yyyy'):'',
                'recibido_inversion_vehiculo': doc.recibido_inversion_vehiculo?:'',
                'buscando_capital': doc.buscando_capital?:'',
                'capital_cuanto': doc.capital_cuanto?:'',
                'vehiculo_inversion': doc.vehiculo_inversion?:'',
                'fecha_fundacion': doc.fecha_fundacion?DATE_FORMAT(doc.fecha_fundacion, '%dd/%mm/%yyyy'):'',
                'lanzar_producto': doc.lanzar_producto?:'',
                'fecha_lanzamiento': doc.fecha_lanzamiento?DATE_FORMAT(doc.fecha_lanzamiento, '%dd/%mm/%yyyy'):'',
                'patente_ip': doc.patente_ip?:'',
                'modelo_ventas': doc.modelo_ventas?:'',
                'realizado_ventas': doc.realizado_ventas?:'',
                'ventas': doc.ventas?:'',
                'gasto_mensual': doc.gasto_mensual?:'',
                'pierde_dinero': doc.pierde_dinero?:'',
                'socio_exit_empresa': doc.socio_exit_empresa?:''
            }", true);

        $data_total = $this->ArangoDB->Query("
            FOR doc IN emprendimientos 
                $search_txt
                COLLECT WITH COUNT INTO length
            RETURN length", true);

        $items = [];

        // Formateando valores
        foreach ($data as $item){
            if($item['nivel_tlr']!='') $item['nivel_tlr'] = $this->nivel_tlr[$item['nivel_tlr']];
            if($item['pais']!='') $item['pais'] = $this->paises[$item['pais']];
            if($item['recibido_inversion_como']!='') $item['recibido_inversion_como'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['recibido_inversion_como']);
            if($item['vehiculo_inversion']!='') $item['vehiculo_inversion'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['vehiculo_inversion']);
            if($item['recibido_inversion_vehiculo']!='') $item['recibido_inversion_vehiculo'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['recibido_inversion_vehiculo']);
            if($item['clientes']!=''){
                $item['clientes'] = $this->MergeArrays($item['clientes']);
                $item['clientes_mes1'] = ($item['clientes'][0])?$item['clientes'][0]:'';
                $item['clientes_mes2'] = ($item['clientes'][1])?$item['clientes'][1]:'';
                $item['clientes_mes3'] = ($item['clientes'][2])?$item['clientes'][2]:'';
            }else{
                $item['clientes_mes1'] = $item['clientes_mes2'] = $item['clientes_mes3'] = '';
            }
            if($item['usuarios']!=''){
                $item['usuarios'] = $this->MergeArrays($item['usuarios']);
                $item['usuarios_mes1'] = ($item['usuarios'][0])?$item['usuarios'][0]:'';
                $item['usuarios_mes2'] = ($item['usuarios'][1])?$item['usuarios'][1]:'';
                $item['usuarios_mes3'] = ($item['usuarios'][2])?$item['usuarios'][2]:'';
            }else{
                $item['usuarios_mes1'] = $item['usuarios_mes2'] = $item['usuarios_mes3'] = '';
            }
            if($item['capital']!='') $item['capital'] = $this->MergeCapital($item['capital']);
            if($item['ventas']!=''){
                $item['ventas'] = $this->MergeArrays($item['ventas']);
                $item['ventas_mes1'] = ($item['ventas'][0])?$this->MoneyFormat($item['ventas'][0]):'';
                $item['ventas_mes2'] = ($item['ventas'][1])?$this->MoneyFormat($item['ventas'][1]):'';
                $item['ventas_mes3'] = ($item['ventas'][2])?$this->MoneyFormat($item['ventas'][2]):'';
            }else{
                $item['ventas_mes1'] = $item['ventas_mes2'] = $item['ventas_mes3'] = '';
            }
            if($item['gasto_mensual']!='') $item['gasto_mensual'] = $this->MoneyFormat($item['gasto_mensual']);
            if($item['pierde_dinero']!='') $item['pierde_dinero'] = $this->MoneyFormat($item['pierde_dinero']);
            $items[] = $item;
        }

        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $items;
        return json_encode($datos);
    }

    private function GetFromMultipleArray($origen, $destino){
        $return = [];
        foreach ($destino as $item){
            $return[]=$origen[$item];
        }
        return $return;
    }

    private function MergeArrays($array){
        $return = [];
        foreach ($array as $first_key=>$first_val){
            foreach ($first_val as $key=>$val){
                $return[] = $val;
            }
        }
        return $return;
    }

    private function MergeCapital($array){
        $return = [];
        foreach ($array as $first_key=>$first_val){
            $mes = (isset($first_val->mes))?$this->n_meses[$first_val->mes]:'';
            $return[] = $first_val->socio.';'.$first_val->year.';'.$mes.';'.$this->MoneyFormat($first_val->monto);
        }
        $txt = implode(',',$return);
        $txt = str_replace( [',',';'], ['<br/>',','], $txt );
        return $txt;
    }

    private function MoneyFormat($number){
        $number = str_replace( ',', '', $number );
        $number = (is_float($number))?:(float)$number;
        return '$'.number_format($number, 2, '.', ',');
    }
}