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
     * Reporte Usuarios Emprendimientos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
                    FILTER u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.isAdmin==0 $search_txt
                    LIMIT $offset,$limit
                    SORT u.$sort $order
            RETURN {'id':u._key, 'nombre':CONCAT(u.nombre,' ',u.apellidos), 'email':u.email}", true);

        $data_total = $this->ArangoDB->Query("
            FOR u IN users
                FILTER u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.isAdmin==0 $search_txt
                COLLECT WITH COUNT INTO length
            RETURN length", true);

        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $data;
        return json_encode($datos);
    }

    /**
     * Reporte Usuarios
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Usuarios(){
        return view('admin.reportes.usuarios');
    }

    /**
     * Reporte Usuarios  AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function UsuariosAjax(Request $request){

        $search_txt = "";
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = trim($request->get('search'));
        $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
        $order = trim($request->get('order'));

        if($search!='') $search_txt = 'AND (LOWER(CONCAT(u.nombre," ",u.apellidos)) LIKE "%'.strtolower($search).'%" OR LOWER(u.email) LIKE "%'.strtolower($search).'%")';

        $data = $this->ArangoDB->Query("
            FOR u IN users
                    FILTER u.isAdmin==0 $search_txt
                    LIMIT $offset,$limit
                    SORT u.$sort $order
            RETURN {'_key':u._key, 'nombre':CONCAT(u.nombre,' ',u.apellidos), 'email':u.email, 'telefono': u.telefono, 'validated': (u.validated==1)?'Si':'No', 'fecha': u.created_time?DATE_FORMAT(u.created_time.date, '%dd/%mm/%yyyy'):''}", true);

        $data_total = $this->ArangoDB->Query("
            FOR u IN users
                FILTER u.isAdmin==0 $search_txt
                COLLECT WITH COUNT INTO length
            RETURN length", true);

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

        if($search!='') $search_txt = 'AND doc.nombre LIKE "%'.strtolower($search).'%"';

        $data = $this->ArangoDB->Query("
            FOR doc IN emprendimientos
                FOR user IN users
                    FILTER user._key == doc.userKey $search_txt
                    LIMIT $offset,$limit
                    SORT doc.$sort $order
            RETURN {
                '_key': doc._key,
                'emprendimiento': doc.nombre,
                'descripcion': doc.descripcion?:'',
                'usuario':user.nombre? CONCAT(user.nombre,' ',user.apellidos):'',
                'email': user.email?:'',
                'telefono': user.telefono?:'',
                'convocatoria': (FOR uc IN usuario_convocatoria FOR conv IN convocatorias FILTER uc.emprendimiento_id == doc._key AND conv._key == uc.convocatoria_id  RETURN conv.nombre),
                'numero_colaboradores': doc.numero_colaboradores?:'',
                'logo_file': doc.logo_file?:'',
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
                'como_te_enteraste_cual': doc.como_te_enteraste_cual?:'',
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
                'recibido_capital_cuanto': doc.recibido_capital_cuanto?:'',
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
                FOR u IN users
                    FILTER u._key == doc.userKey $search_txt
                    COLLECT WITH COUNT INTO length
            RETURN length", true);

        $items = [];

        // Formateando valores
        foreach ($data as $item){
            if($item['nivel_tlr']!='') $item['nivel_tlr'] = $this->nivel_tlr[$item['nivel_tlr']];
            if($item['pais']!='') $item['pais'] = $this->paises[$item['pais']];
            /*if($item['recibido_inversion_como']!='') $item['recibido_inversion_como'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['recibido_inversion_como']);
            if($item['vehiculo_inversion']!='') $item['vehiculo_inversion'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['vehiculo_inversion']);
            if($item['recibido_inversion_vehiculo']!='') $item['recibido_inversion_vehiculo'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['recibido_inversion_vehiculo']);
            if($item['clientes']!=''){
                $item['clientes'] = $this->MergeArrays($item['clientes']);
                $item['clientes_mes1'] = (!empty($item['clientes'][0]))?$item['clientes'][0]:'';
                $item['clientes_mes2'] = (!empty($item['clientes'][1]))?$item['clientes'][1]:'';
                $item['clientes_mes3'] = (!empty($item['clientes'][2]))?$item['clientes'][2]:'';
            }else{
                $item['clientes_mes1'] = $item['clientes_mes2'] = $item['clientes_mes3'] = '';
            }
            if($item['usuarios']!=''){
                $item['usuarios'] = $this->MergeArrays($item['usuarios']);
                $item['usuarios_mes1'] = (!empty($item['usuarios'][0]))?$item['usuarios'][0]:'';
                $item['usuarios_mes2'] = (!empty($item['usuarios'][1]))?$item['usuarios'][1]:'';
                $item['usuarios_mes3'] = (!empty($item['usuarios'][2]))?$item['usuarios'][2]:'';
            }else{
                $item['usuarios_mes1'] = $item['usuarios_mes2'] = $item['usuarios_mes3'] = '';
            }
            if($item['capital']!='') $item['capital'] = $this->MergeCapital($item['capital']);
            if($item['ventas']!=''){
                $item['ventas'] = $this->MergeArrays($item['ventas']);
                $item['ventas_mes1'] = (!empty($item['ventas'][0]))?$this->MoneyFormat($item['ventas'][0]):'';
                $item['ventas_mes2'] = (!empty($item['ventas'][1]))?$this->MoneyFormat($item['ventas'][1]):'';
                $item['ventas_mes3'] = (!empty($item['ventas'][2]))?$this->MoneyFormat($item['ventas'][2]):'';
            }else{
                $item['ventas_mes1'] = $item['ventas_mes2'] = $item['ventas_mes3'] = '';
            }
            if($item['gasto_mensual']!='') $item['gasto_mensual'] = $this->MoneyFormat($item['gasto_mensual']);
            if($item['pierde_dinero']!='') $item['pierde_dinero'] = $this->MoneyFormat($item['pierde_dinero']);*/
            if($item['logo_file']!='') $item['logo_file'] = url('/').$item['logo_file'];
            $items[] = $item;
        }

        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $items;
        return json_encode($datos);
    }

    /**
     * Reporte Emprendores Tec
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function EmprendedoresTec(Request $request){
        return view('admin.reportes.emprendedoresTec');
    }

    /**
     * Reporte Emprendedores Tec AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function EmprendedoresTecAjax(Request $request){

        $search_txt = "";
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = trim($request->get('search'));
        $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
        $order = trim($request->get('order'));

        if($search!='') $search_txt = 'AND LOWER(CONCAT(u.nombre," ",u.apellidos)) LIKE "%'.strtolower($search).'%"';

        $data = $this->ArangoDB->Query("
          LET estados = ([{ id: '1', nombre: 'Aguascalientes' },{ id: '2', nombre: 'Baja California' },{ id: '3', nombre: 'Baja California Sur' },{ id: '4', nombre: 'Campeche' },{ id: '5', nombre: 'Chiapas' },{ id: '6', nombre: 'Chihuahua' },{ id: '7', nombre: 'Coahuila de Zaragoza' },{ id: '8', nombre: 'Colima' },{ id: '9', nombre: 'Ciudad de México' },{ id: '10', nombre: 'Durango' },{ id: '11', nombre: 'Guanajuato' },{ id: '12', nombre: 'Guerrero' },{ id: '13', nombre: 'Hidalgo' },{ id: '14', nombre: 'Jalisco' },{ id: '15', nombre: 'Estado de Mexico' },{ id: '16', nombre: 'Michoacan de Ocampo' },{ id: '17', nombre: 'Morelos' },{ id: '18', nombre: 'Nayarit' },{ id: '19', nombre: 'Nuevo Leon' },{ id: '20', nombre: 'Oaxaca' },{ id: '21', nombre: 'Puebla' },{ id: '22', nombre: 'Queretaro de Arteaga' },{ id: '23', nombre: 'Quintana Roo' },{ id: '24', nombre: 'San Luis Potosi' },{ id: '25', nombre: 'Sinaloa' },{ id: '26', nombre: 'Sonora' },{ id: '27', nombre: 'Tabasco' },{ id: '28', nombre: 'Tamaulipas' },{ id: '29', nombre: 'Tlaxcala' },{ id: '30', nombre: 'Veracruz' },{ id: '31', nombre: 'Yucatan' },{ id: '32', nombre: 'Zacatecas'}])

          LET campus = ([{ id: '0', nombre: 'Monterrey' },{ id: '1', nombre: 'Chihuahua' },{ id: '2', nombre: 'Ciudad Juárez' },{ id: '3', nombre: 'Laguna' },{ id: '4', nombre: 'Saltillo' },{ id: '5', nombre: 'Tampico' },{ id: '6', nombre: 'Aguascalientes' },{ id: '7', nombre: 'Veracruz' },{ id: '8', nombre: 'Chiapas' },{ id: '9', nombre: 'Ciudad de México' },{ id: '10', nombre: 'Ciudad Obregón' },{ id: '11', nombre: 'Cuernavaca' },{ id: '12', nombre: 'Estado de México' },{ id: '13', nombre: 'Guadalajara' },{ id: '14', nombre: 'Hidalgo' },{ id: '15', nombre: 'Irapuato' },{ id: '16', nombre: 'León' },{ id: '17', nombre: 'Morelia' },{ id: '18', nombre: 'Puebla' },{ id: '19', nombre: 'Querétaro' },{ id: '20', nombre: 'San Luis Potosí' },{ id: '21', nombre: 'Santa Fe' },{ id: '22', nombre: 'Sinaloa' },{ id: '23', nombre: 'Sonora Norte' },{ id: '24', nombre: 'Toluca' },{ id: '25', nombre: 'Zacatecas' }])

          FOR u IN users
          FILTER u.validated == 1 AND u.active == 1 AND u.isAdmin == 0 $search_txt
            FOR p IN perfiles
            FILTER p.userKey == u._key AND p.universidad == '3961308'
              FOR ucon IN usuario_convocatoria
              FILTER ucon.userKey == u._key AND (ucon.convocatoria_id == '10866949' OR ucon.convocatoria_id == '10866728' OR ucon.convocatoria_id == '6718262')
              LIMIT $offset,$limit
              SORT u.$sort $order
              RETURN {
                 'nombre': u.nombre,
                 'apellidos': u.apellidos,
                 'telefono':	u.telefono?u.telefono:'',
                 'matrícula':	p.matricula?p.matricula:'',
                 'biografia': p.biografia?p.biografia:'',
                 'sexo': p.sexo?p.sexo:'',
                 'fecha_nacimiento':	p.fecha_nacimiento?DATE_FORMAT(DATE_TIMESTAMP(p.fecha_nacimiento),'%dd/%mm/%yyyy'):'',
                 'dedica_a': p.a_que_se_dedica?p.a_que_se_dedica:'',
                 'linkedin':	p.linkedin?p.linkedin:'',
                 'pais':	p.pais == '121' ? 'México' : 'Extranjero',
                 'estado': p.estado?(FOR e IN estados FILTER e.id == p.estado RETURN e.nombre):'',
                 'ciudad': p.ciudad?p.ciudad:'',
                 'universidad': p.universidad?(FOR uni IN universidades FILTER p.universidad == uni._key RETURN uni.nombre):'',
                 'campus': p.campus?(FOR c IN campus FILTER c.id == p.campus RETURN c.nombre):'',
                 'carrera_cursando': p.actualmente_cursando_carrera?p.actualmente_cursando_carrera:'',
                 'fecha_graduacion': p.fecha_graduacion?DATE_FORMAT(p.fecha_graduacion,'%dd/%mm/%yyyy'):'',
                 'emprendimiento': ucon.emprendimiento_id?(FOR em IN emprendimientos FILTER em._key == ucon.emprendimiento_id RETURN em.nombre):'',
                 'convocatoria': ucon.convocatoria_id?(FOR con IN convocatorias FILTER con._key == ucon.convocatoria_id RETURN con.nombre):''
              }", true);

        $data_total = $this->ArangoDB->Query("
          FOR u IN users
          FILTER u.validated == 1 AND u.active == 1 AND u.isAdmin == 0 $search_txt
            FOR p IN perfiles
            FILTER p.userKey == u._key AND p.universidad == '3961308'
              FOR ucon IN usuario_convocatoria
              FILTER ucon.userKey == u._key AND (ucon.convocatoria_id == '10866949' OR ucon.convocatoria_id == '10866728' OR ucon.convocatoria_id == '6718262')
              COLLECT WITH COUNT INTO length
              RETURN length", true);

        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $data;
        return json_encode($datos);
    }

    /**
     * Reporte Emprendimientos Full
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function EmprendimientosFull(Request $request){
        return view('admin.reportes.emprendimientosFull');
    }

    /**
     * Reporte Emprendimientos Full AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function EmprendimientosFullAjax(Request $request){

      $search_txt = "";
      $offset = $request->get('offset');
      $limit = $request->get('limit');
      $search = trim($request->get('search'));
      $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
      $order = trim($request->get('order'));

      if($search!='') $search_txt = 'AND doc.nombre LIKE "%'.strtolower($search).'%"';

      $data = $this->ArangoDB->Query("
          LET campus = ([{ id: '0', nombre: 'Monterrey' },{ id: '1', nombre: 'Chihuahua' },{ id: '2', nombre: 'Ciudad Juárez' },{ id: '3', nombre: 'Laguna' },{ id: '4', nombre: 'Saltillo' },{ id: '5', nombre: 'Tampico' },{ id: '6', nombre: 'Aguascalientes' },{ id: '7', nombre: 'Veracruz' },{ id: '8', nombre: 'Chiapas' },{ id: '9', nombre: 'Ciudad de México' },{ id: '10', nombre: 'Ciudad Obregón' },{ id: '11', nombre: 'Cuernavaca' },{ id: '12', nombre: 'Estado de México' },{ id: '13', nombre: 'Guadalajara' },{ id: '14', nombre: 'Hidalgo' },{ id: '15', nombre: 'Irapuato' },{ id: '16', nombre: 'León' },{ id: '17', nombre: 'Morelia' },{ id: '18', nombre: 'Puebla' },{ id: '19', nombre: 'Querétaro' },{ id: '20', nombre: 'San Luis Potosí' },{ id: '21', nombre: 'Santa Fe' },{ id: '22', nombre: 'Sinaloa' },{ id: '23', nombre: 'Sonora Norte' },{ id: '24', nombre: 'Toluca' },{ id: '25', nombre: 'Zacatecas' }])

          FOR doc IN emprendimientos
              FOR user IN users
                  FILTER user._key == doc.userKey $search_txt
                    LET vPerfiles = (
                        FOR p IN perfiles
                        FILTER p.userKey == user._key
                        RETURN p
                    )
                    LIMIT $offset,$limit
                    SORT doc.$sort $order
          RETURN {
              '_key': doc._key,
              'emprendimiento': doc.nombre,
              'descripcion': doc.descripcion?:'',
              'usuario':user.nombre? CONCAT(user.nombre,' ',user.apellidos):'',
              'email': user.email?:'',
              'telefono': user.telefono?:'',
              'convocatoria': (FOR uc IN usuario_convocatoria FOR conv IN convocatorias FILTER uc.emprendimiento_id == doc._key AND conv._key == uc.convocatoria_id  RETURN conv.nombre),
              'numero_colaboradores': doc.numero_colaboradores?:'',
              'logo_file': doc.logo_file?:'',
              'cedula_file': doc.cedula_file?:'',
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
              'como_te_enteraste_cual': doc.como_te_enteraste_cual?:'',
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
              'recibido_capital_cuanto': doc.recibido_capital_cuanto?:'',
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
              'socio_exit_empresa': doc.socio_exit_empresa?:'',
              'biografia': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.biografia),
              'sexo': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.sexo),
              'fecha_nacimiento': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN DATE_FORMAT(perfil.fecha_nacimiento, '%dd/%mm/%yyyy')),
              'a_que_se_dedica': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.a_que_se_dedica),
              'linkedin': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.linkedin),
              'universidad': (LET universidad = (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.universidad)
                              FOR uni IN universidades FILTER universidad[0] == uni._key RETURN uni.nombre),
              'campus': (LET vCampus = (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.campus)
                         FOR c IN campus FILTER vCampus[0] == c.id RETURN c.nombre),
              'universidad_otra': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.universidad_otra),
              'actualmente_cursando_carrera': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.actualmente_cursando_carrera),
              'fecha_graduacion': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN DATE_FORMAT(perfil.fecha_graduacion, '%dd/%mm/%yyyy')),
              'matricula': (FOR perfil IN vPerfiles FILTER perfil.userKey == user._key RETURN perfil.matricula)
          }", true);

      $data_total = $this->ArangoDB->Query("
          FOR doc IN emprendimientos
              FOR u IN users
                  FILTER u._key == doc.userKey $search_txt
                  COLLECT WITH COUNT INTO length
          RETURN length", true);

      $items = [];

      // Formateando valores
      foreach ($data as $item){
          if($item['nivel_tlr']!='') $item['nivel_tlr'] = $this->nivel_tlr[$item['nivel_tlr']];
          if($item['pais']!='') $item['pais'] = $this->paises[$item['pais']];
          /*if($item['recibido_inversion_como']!='') $item['recibido_inversion_como'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['recibido_inversion_como']);
          if($item['vehiculo_inversion']!='') $item['vehiculo_inversion'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['vehiculo_inversion']);
          if($item['recibido_inversion_vehiculo']!='') $item['recibido_inversion_vehiculo'] = $this->GetFromMultipleArray($this->vehiculos_inversion, $item['recibido_inversion_vehiculo']);
          if($item['clientes']!=''){
              $item['clientes'] = $this->MergeArrays($item['clientes']);
              $item['clientes_mes1'] = (!empty($item['clientes'][0]))?$item['clientes'][0]:'';
              $item['clientes_mes2'] = (!empty($item['clientes'][1]))?$item['clientes'][1]:'';
              $item['clientes_mes3'] = (!empty($item['clientes'][2]))?$item['clientes'][2]:'';
          }else{
              $item['clientes_mes1'] = $item['clientes_mes2'] = $item['clientes_mes3'] = '';
          }
          if($item['usuarios']!=''){
              $item['usuarios'] = $this->MergeArrays($item['usuarios']);
              $item['usuarios_mes1'] = (!empty($item['usuarios'][0]))?$item['usuarios'][0]:'';
              $item['usuarios_mes2'] = (!empty($item['usuarios'][1]))?$item['usuarios'][1]:'';
              $item['usuarios_mes3'] = (!empty($item['usuarios'][2]))?$item['usuarios'][2]:'';
          }else{
              $item['usuarios_mes1'] = $item['usuarios_mes2'] = $item['usuarios_mes3'] = '';
          }
          if($item['capital']!='') $item['capital'] = $this->MergeCapital($item['capital']);
          if($item['ventas']!=''){
              $item['ventas'] = $this->MergeArrays($item['ventas']);
              $item['ventas_mes1'] = (!empty($item['ventas'][0]))?$this->MoneyFormat($item['ventas'][0]):'';
              $item['ventas_mes2'] = (!empty($item['ventas'][1]))?$this->MoneyFormat($item['ventas'][1]):'';
              $item['ventas_mes3'] = (!empty($item['ventas'][2]))?$this->MoneyFormat($item['ventas'][2]):'';
          }else{
              $item['ventas_mes1'] = $item['ventas_mes2'] = $item['ventas_mes3'] = '';
          }
          if($item['gasto_mensual']!='') $item['gasto_mensual'] = $this->MoneyFormat($item['gasto_mensual']);
          if($item['pierde_dinero']!='') $item['pierde_dinero'] = $this->MoneyFormat($item['pierde_dinero']);*/
          if($item['logo_file']!='') $item['logo_file'] = url('/').$item['logo_file'];
          if($item['cedula_file']!='') $item['cedula_file'] = url('/').$item['cedula_file'];
          $items[] = $item;
      }

      $datos['total'] = $data_total[0][0];
      $datos['rows'] = $items;
      return json_encode($datos);
    }

    /**
     * Reporte Usuarios Full
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function UsuariosFull(){
        return view('admin.reportes.usuariosFull');
    }

    /**
     * Reporte Usuarios Full AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function UsuariosFullAjax(Request $request){

        $search_txt = "";
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = trim($request->get('search'));
        $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
        $order = trim($request->get('order'));

        if($search!='') $search_txt = 'AND (LOWER(CONCAT(u.nombre," ",u.apellidos)) LIKE "%'.strtolower($search).'%" OR LOWER(u.email) LIKE "%'.strtolower($search).'%")';

        $data = $this->ArangoDB->Query("
            LET estados = ([{ id: '1', nombre: 'Aguascalientes' },{ id: '2', nombre: 'Baja California' },{ id: '3', nombre: 'Baja California Sur' },{ id: '4', nombre: 'Campeche' },{ id: '5', nombre: 'Chiapas' },{ id: '6', nombre: 'Chihuahua' },{ id: '7', nombre: 'Coahuila de Zaragoza' },{ id: '8', nombre: 'Colima' },{ id: '9', nombre: 'Ciudad de México' },{ id: '10', nombre: 'Durango' },{ id: '11', nombre: 'Guanajuato' },{ id: '12', nombre: 'Guerrero' },{ id: '13', nombre: 'Hidalgo' },{ id: '14', nombre: 'Jalisco' },{ id: '15', nombre: 'Estado de Mexico' },{ id: '16', nombre: 'Michoacan de Ocampo' },{ id: '17', nombre: 'Morelos' },{ id: '18', nombre: 'Nayarit' },{ id: '19', nombre: 'Nuevo Leon' },{ id: '20', nombre: 'Oaxaca' },{ id: '21', nombre: 'Puebla' },{ id: '22', nombre: 'Queretaro de Arteaga' },{ id: '23', nombre: 'Quintana Roo' },{ id: '24', nombre: 'San Luis Potosi' },{ id: '25', nombre: 'Sinaloa' },{ id: '26', nombre: 'Sonora' },{ id: '27', nombre: 'Tabasco' },{ id: '28', nombre: 'Tamaulipas' },{ id: '29', nombre: 'Tlaxcala' },{ id: '30', nombre: 'Veracruz' },{ id: '31', nombre: 'Yucatan' },{ id: '32', nombre: 'Zacatecas'}])

            LET campus = ([{ id: '0', nombre: 'Monterrey' },{ id: '1', nombre: 'Chihuahua' },{ id: '2', nombre: 'Ciudad Juárez' },{ id: '3', nombre: 'Laguna' },{ id: '4', nombre: 'Saltillo' },{ id: '5', nombre: 'Tampico' },{ id: '6', nombre: 'Aguascalientes' },{ id: '7', nombre: 'Veracruz' },{ id: '8', nombre: 'Chiapas' },{ id: '9', nombre: 'Ciudad de México' },{ id: '10', nombre: 'Ciudad Obregón' },{ id: '11', nombre: 'Cuernavaca' },{ id: '12', nombre: 'Estado de México' },{ id: '13', nombre: 'Guadalajara' },{ id: '14', nombre: 'Hidalgo' },{ id: '15', nombre: 'Irapuato' },{ id: '16', nombre: 'León' },{ id: '17', nombre: 'Morelia' },{ id: '18', nombre: 'Puebla' },{ id: '19', nombre: 'Querétaro' },{ id: '20', nombre: 'San Luis Potosí' },{ id: '21', nombre: 'Santa Fe' },{ id: '22', nombre: 'Sinaloa' },{ id: '23', nombre: 'Sonora Norte' },{ id: '24', nombre: 'Toluca' },{ id: '25', nombre: 'Zacatecas' }])

            FOR u IN users
              FILTER u.isAdmin==0 $search_txt
                FOR p IN perfiles
                FILTER p.userKey == u._key
                LIMIT $offset,$limit
                SORT u.$sort $order
            RETURN {
              '_key':u._key,
              'nombre':CONCAT(u.nombre,' ',u.apellidos),
              'matricula':	p.matricula?p.matricula:'',
              'email':u.email,
              'telefono': u.telefono,
              'validated': (u.validated==1)?'Si':'No',
              'fecha': u.created_time?DATE_FORMAT(u.created_time.date, '%dd/%mm/%yyyy'):'',
              'biografia': p.biografia?p.biografia:'',
              'sexo': p.sexo?p.sexo:'',
              'fecha_nacimiento':	p.fecha_nacimiento?DATE_FORMAT(DATE_TIMESTAMP(p.fecha_nacimiento),'%dd/%mm/%yyyy'):'',
              'dedica_a': p.a_que_se_dedica?p.a_que_se_dedica:'',
              'linkedin':	p.linkedin?p.linkedin:'',
              'pais':	p.pais == '121' ? 'México' : 'Extranjero',
              'estado': p.estado?(FOR e IN estados FILTER e.id == p.estado RETURN e.nombre):'',
              'ciudad': p.ciudad?p.ciudad:'',
              'universidad': p.universidad?(FOR uni IN universidades FILTER p.universidad == uni._key RETURN uni.nombre):'',
              'campus': p.campus?(FOR c IN campus FILTER c.id == p.campus RETURN c.nombre):'',
              'carrera_cursando': p.actualmente_cursando_carrera?p.actualmente_cursando_carrera:'',
              'fecha_graduacion': p.fecha_graduacion?DATE_FORMAT(p.fecha_graduacion,'%dd/%mm/%yyyy'):''
            }", true);

        $data_total = $this->ArangoDB->Query("
            FOR u IN users
              FILTER u.isAdmin==0 $search_txt
                FOR p IN perfiles
                FILTER p.userKey == u._key
                COLLECT WITH COUNT INTO length
                RETURN length", true);

        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $data;
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
