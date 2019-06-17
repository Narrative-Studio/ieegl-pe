<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArangoDB;

class PanelController extends Controller
{
    protected $ArangoDB;

    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        $this->middleware('is_user');
    }

    public function Index(){
        //Obteniendo perfil y redireccionando si no ha completado el perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        if(count($data)<1){
            return redirect()->action('PanelPerfiles@Index');
        }else{
            $perfil = $data[0];
            $query = '
                LET count_e = (FOR e IN emprendimientos
                    FILTER e.userKey==\''.auth()->user()->_key.'\'
                    COLLECT WITH COUNT INTO length 
                    RETURN length)
                    
                LET count_app = (FOR e IN usuario_convocatoria
                    FILTER e.userKey==\''.auth()->user()->_key.'\'
                    COLLECT WITH COUNT INTO length 
                    RETURN length)
                
                LET convocatorias = (FOR convocatoria IN convocatorias
                    FOR entidad IN entidades
                        FOR quien IN quien
                            FILTER convocatoria.quien == quien._key AND convocatoria.activo == "Si" AND convocatoria.fecha_inicio_convocatoria <= \''.time().'\' AND convocatoria.fecha_fin_convocatoria <= \''.time().'\'  AND convocatoria.entidad  == entidad._key
                            SORT convocatoria.created_at ASC LIMIT 3
                            RETURN merge(convocatoria, {quien_nombre: quien.nombre}, {entidad: entidad.nombre,  entidad_desc: entidad.descripcion, entidad_key: entidad._key, entidad_ext: entidad.ext} )
                )    
                    
                return {total_e: count_e[0], total_app: count_app[0], convocatorias: convocatorias}            
            ';
            $dashboard = $this->ArangoDB->Query($query);
            $dashboard = $dashboard[0];
            //dd($dashboard);exit();
            return view('panel.dashboard',compact('perfil','dashboard'));
        }
    }
}