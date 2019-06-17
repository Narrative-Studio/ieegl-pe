<?php
namespace App\Http\Controllers;
use App\Repositories\ArangoDB;
use Illuminate\Http\Request;
class AdminController extends Controller
{

    protected $ArangoDB;

    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        $this->middleware('auth:admin');
    }

    public function Index()
    {
        $query_user = (auth()->user()->isAdmin != 1)?'convocatoria.responsable == "'.auth()->user()->_key.'" AND':'';
        $query = '
            LET total_usuarios = (FOR e IN users FILTER e.isAdmin==0 COLLECT WITH COUNT INTO length RETURN length)
            LET usuarios_dia = (FOR e IN users FILTER e.isAdmin==0  && e.created_time.date!=null && DATE_FORMAT(DATE_TIMESTAMP(e.created_time.date), "%dd.%mm.%yyyy")==DATE_FORMAT(DATE_NOW(), "%dd.%mm.%yyyy") COLLECT WITH COUNT INTO length RETURN length)
            LET usuarios_mes = (FOR e IN users FILTER e.isAdmin==0  && e.created_time.date!=null && DATE_FORMAT(DATE_TIMESTAMP(e.created_time.date), "%mm.%yyyy")==DATE_FORMAT(DATE_NOW(), "%mm.%yyyy") COLLECT WITH COUNT INTO length RETURN length)
            LET total_empre = (FOR e IN emprendimientos COLLECT WITH COUNT INTO length RETURN length)
            LET total_convo = (FOR e IN convocatorias COLLECT WITH COUNT INTO length RETURN length)
            LET total_apps = (FOR e IN usuario_convocatoria COLLECT WITH COUNT INTO length RETURN length)
            
            LET convocatorias = (FOR convocatoria IN convocatorias
                FOR users IN users
                    FOR entidad IN entidades
                      LET aplicaciones = (
                        FOR a IN usuario_convocatoria
                          FILTER a.convocatoria_id == convocatoria._key
                          COLLECT WITH COUNT INTO length RETURN length
                        )            
                        FILTER '.$query_user.' convocatoria.activo=="aprobacion" AND convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key
                        SORT convocatoria._key ASC LIMIT 5
                    RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre}, {total: aplicaciones[0]})
            )         
            
            return {
                usuarios: {total:total_usuarios[0], dia: usuarios_dia[0], mes: usuarios_mes[0]}, 
                empre: {total:total_empre[0], dia: usuarios_dia[0], mes: usuarios_mes[0]}, 
                convo: {total:total_convo[0], dia: usuarios_dia[0], mes: usuarios_mes[0]}, 
                apps: {total:total_apps[0]},
                convocatorias: convocatorias
            }        
        ';
        $dashboard = $this->ArangoDB->Query($query);
        $dashboard = $dashboard[0];
        return view('admin.dashboard', compact('dashboard'));
    }
}