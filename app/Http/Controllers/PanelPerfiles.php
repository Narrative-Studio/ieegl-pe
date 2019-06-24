<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilDatosPersonalesRequest;
use App\Http\Requests\PerfilEstudiosRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class PanelPerfiles extends Controller
{
    protected $EdgeHandler;
    protected $ArangoDB;
    private $collection = 'perfiles';
    private $controller = 'PanelPerfiles';

    /**
     * Industrias constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        ArangoException::enableLogging();
    }

    /**
     * Primera parte del Perfil - Datos Personales
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(){
        // Perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        $item = (count($data)>0)?$data[0]:[];
        $paises = $this->paises; // Paises
        $estados = $this->estados; // Estados
        $sexo = $this->sexo;
        $dedicas = $this->a_que_te_dedicas;
        return view('panel.'.$this->collection.'.datos-personales', compact('paises','estados', 'item', 'sexo', 'dedicas'));
    }

    /**
     * Estudios para el Perfil del Usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Estudios(){
        //Campus TEC
        $campus = $this->campus;
        //Obteniendo perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        $item = (count($data)>0)?$data[0]:[];
        // Obteniendo Universidades
        $universidades = $this->ArangoDB->Query('FOR doc IN universidades RETURN doc', true);
        $universidades = $this->ArangoDB->SelectFormat($universidades, '_key','nombre');
        $estudiando = $this->estudiando;
        return view('panel.'.$this->collection.'.estudios', compact('item','universidades','campus','estudiando'));
    }

    /**
     * Mostrar Cuenta del Usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Cuenta(){
        //Obteniendo Usuario
        $data = $this->ArangoDB->Query('FOR doc IN users FILTER doc._key == "'.auth()->user()->_key.'" RETURN doc');
        $item = $data[0];
        return view('panel.'.$this->collection.'.cuenta', compact('item'));
    }

    /**
     * Guardar Datos Personales del Perfil
     * @param PerfilDatosPersonalesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveDatosPersonales(PerfilDatosPersonalesRequest $request){

        $document = [];
        $document['biografia'] = $request->get('biografia');
        $document['sexo'] = $request->get('sexo');
        $document['fecha_nacimiento'] = $request->get('fecha_nacimiento');
        $document['a_que_se_dedica'] = $request->get('a_que_se_dedica');
        $document['linkedin'] = $request->get('linkedin');
        $document['pais'] = $request->get('pais');
        if($request->get('estado_otro')!=''){
            $document['estado'] = null;
            $document['estado_otro'] = $request->get('estado_otro');
        }else{
            $document['estado'] = $request->get('estado');
            $document['estado_otro'] = null;
        }
        $document['ciudad'] = $request->get('ciudad');
        $document['userKey'] = auth()->user()->_key;

        // Creando Nuevo Registro
        if($request->get('id')==''){

            // Buscar que un perfil nuevo no se duplique
            $total = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey=="'.auth()->user()->_key.'" COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];

            if($total<1){
                $documentId = $this->ArangoDB->Save($this->collection, $document);
                //Creando Edge
                $this->ArangoDB->CreateEdge(['label' => 'hasPerfil', 'created_time'=>now()], 'hasPerfil', 'users/'.auth()->user()->_key, $documentId);
            }else{
                Session::flash('status_error', 'Error guardando el perfil, vuelve a intentarlo');
                return redirect()->action($this->controller.'@Index');
            }
        }else{
            // Actualizando Registro
            $document['created_time'] = now();
            $documentId = $request->get('id');
            $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
        }

        // Guardando Imagen de Avatar
        if($_FILES['foto']['size'] != 0 && $_FILES['foto']['error'] == 0){
            $img = Image::make($_FILES['foto']['tmp_name']);
            $img->fit(300, 300)->save(public_path('/users_pics/user_'. auth()->user()->_key .'.jpg', 100));
        }

        Session::flash('status_success', 'Datos Personales Guardados');
        return redirect()->action($this->controller.'@Estudios');
    }

    /**
     * Guardar Estudios del Perfil
     * @param PerfilEstudiosRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveEstudios(PerfilEstudiosRequest $request){

        $document = [];
        $document['actualmente_cursando_carrera'] = $request->get('actualmente_cursando_carrera');
        $document['userKey'] = auth()->user()->_key;
        if($request->get('actualmente_cursando_carrera')=='Preparatoria en el Tec' || $request->get('actualmente_cursando_carrera')=='Licenciatura en el Tec' || $request->get('actualmente_cursando_carrera')=='Posgrado en el Tec'){
            $document['campus'] = $request->get('campus');
            $document['matricula'] = $request->get('matricula');
        }else{
            $document['campus'] = null;
            $document['matricula'] = null;
        }

        // Creando Nuevo Registro
        if($request->get('id')==''){
            $documentId = $this->ArangoDB->Save($this->collection, $document);

            //Creando Edge
            $this->ArangoDB->CreateEdge(['label' => 'hasPerfil', 'created_time'=>now()], 'hasPerfil', 'users/'.auth()->user()->_key, $documentId);
        }else{
            // Actualizando Registro
            $documentId = $request->get('id');
            $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
        }
        return redirect()->action($this->controller.'@Final');
    }

    /**
     * Guardar Datos de la Cuenta
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveCuenta(UserRequest $request){

        $document = [];
        $document['nombre'] = $request->get('nombre');
        $document['apellidos'] = $request->get('apellidos');
        $document['telefono'] = $request->get('telefono');
        if($request->get('password')!='') $document['password'] = Hash::make($request->get('password'));

        // Actualizando Registro
        $this->ArangoDB->Update('users', 'users/'.auth()->user()->_key, $document);

        Session::flash('status_success', 'Cuenta Guardada');
        return redirect()->action($this->controller.'@Cuenta');
    }

    /**
     * Perfil Completo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Final(){
        return view('panel.'.$this->collection.'.final');
    }

}