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
    private $estados = ['1' => 'Aguascalientes','2' => 'Baja California','3' => 'Baja California Sur','4' => 'Campeche','5' => 'Chiapas','6' => 'Chihuahua','7' => 'Coahuila de Zaragoza','8' => 'Colima','9' => 'Ciudad de México','10' => 'Durango','11' => 'Guanajuato','12' => 'Guerrero','13' => 'Hidalgo','14' => 'Jalisco','15' => 'Estado de Mexico','16' => 'Michoacan de Ocampo','17' => 'Morelos','18' => 'Nayarit','19' => 'Nuevo Leon','20' => 'Oaxaca','21' => 'Puebla','22' => 'Queretaro de Arteaga','23' => 'Quintana Roo','24' => 'San Luis Potosi','25' => 'Sinaloa','26' => 'Sonora','27' => 'Tabasco','28' => 'Tamaulipas','29' => 'Tlaxcala','30' => 'Veracruz','31' => 'Yucatan','32' => 'Zacatecas'];

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
        //Obteniendo perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        $item = (count($data)>0)?$data[0]:[];
        // Paises
        $paises = ["Afganistan","Albania","Alemania","Andorra","Angola","Antartida","Antigua y Barbuda","Arabia Saudi","Argelia","Argentina","Armenia","Australia","Austria","Azerbaiyan","Bahamas","Bahrain","Bangladesh","Barbados","Belgica","Belice","Benin","Bermudas","Bielorrusia","Birmania Myanmar","Bolivia","Bosnia y Herzegovina","Botswana","Brasil","Brunei","Bulgaria","Burkina Faso","Burundi","Butan","Cabo Verde","Camboya","Camerun","Canada","Chad","Chile","China","Chipre","Colombia","Comores","Congo","Corea del Norte","Corea del Sur","Costa de Marfil","Costa Rica","Croacia","Cuba","Dinamarca","Dominica","Ecuador","Egipto","El Salvador","El Vaticano","Emiratos arabes Unidos","Eritrea","Eslovaquia","Eslovenia","España","Estados Unidos","Estonia","Etiopia","Filipinas","Finlandia","Fiji","Francia","Gabon","Gambia","Georgia","Ghana","Gibraltar","Granada","Grecia","Guam","Guatemala","Guinea","Guinea Ecuatorial","Guinea Bissau","Guyana","Haiti","Honduras","Hungria","India","Indian Ocean","Indonesia","Iran","Iraq","Irlanda","Islandia","Israel","Italia","Jamaica","Japon","Jersey","Jordania","Kazajstan","Kenia","Kirguistan","Kiribati","Kuwait","Laos","Lesoto","Letonia","Libano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macedonia","Madagascar","Malasia","Malawi","Maldivas","Mali","Malta","Marruecos","Mauricio","Mauritania","Mexico","Micronesia","Moldavia","Monaco","Mongolia","Montserrat","Mozambique","Namibia","Nauru","Nepal","Nicaragua","Niger","Nigeria","Noruega","Nueva Zelanda","Oman","Paises Bajos","Pakistan","Palau","Panama","Papua Nueva Guinea","Paraguay","Peru","Polonia","Portugal","Puerto Rico","Qatar","Reino Unido","Republica Centroafricana","Republica Checa","Republica Democratica del Congo","Republica Dominicana","Ruanda","Rumania","Rusia","Sahara Occidental","Samoa","San Cristobal y Nevis","San Marino","San Vicente y las Granadinas","Santa Lucia","Santo Tome y Principe","Senegal","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Southern Ocean","Sri Lanka","Swazilandia","Sudafrica","Sudan","Suecia","Suiza","Surinam","Tailandia","Taiwan","Tanzania","Tayikistan","Togo","Tokelau","Tonga","Trinidad y Tobago","Tunez","Turkmekistan","Turquia","Tuvalu","Ucrania","Uganda","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Yemen","Djibouti","Zambia","Zimbabue" ];
        // Estados
        $estados = $this->estados;
        return view('panel.'.$this->collection.'.datos-personales', compact('paises','estados', 'item'));
    }

    /**
     * Estudios para el Perfil del Usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Estudios(){
        //Campus TEC
        $campus = ["Monterrey","Chihuahua","Ciudad Juarez", "Laguna","Saltillo","Tampico"];
        //Obteniendo perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        $item = (count($data)>0)?$data[0]:[];
        // Obteniendo Universidades
        $universidades = $this->ArangoDB->Query('FOR doc IN universidades RETURN doc', true);
        $universidades = $this->ArangoDB->SelectFormat($universidades, '_key','nombre');
        return view('panel.'.$this->collection.'.estudios', compact('item','universidades','campus'));
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
            $documentId = $this->ArangoDB->Save($this->collection, $document);

            //Creando Edge
            $this->ArangoDB->CreateEdge(['label' => 'hasPerfil', 'created_time'=>now()], 'hasPerfil', 'users/'.auth()->user()->_key, $documentId);
        }else{
            // Actualizando Registro
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
        $document['universidad'] = $request->get('universidad');
        $document['universidad_otra'] = $request->get('universidad_otra');
        $document['fecha_graduacion'] = $request->get('fecha_graduacion');
        $document['userKey'] = auth()->user()->_key;
        if($request->get('universidad')=='3961308'){
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