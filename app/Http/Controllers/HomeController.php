<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Mail\ConfirmationEmail;
use App\Mail\RecoverPassword;
use App\Repositories\ArangoDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ArangoDBClient\Document;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;

    /**
     * HomeController constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        //$this->middleware('guest');
        $this->ArangoDB = $ArangoDB;
        $this->DocumentHandler = $ArangoDB->DocumentHandler();
        $this->CollectionHandler = $ArangoDB->CollectionHandler();
    }

    /**
     * Home del sistema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Index()
    {
        return view('web.home');
    }

    /**
     * Restringir a un usuario entrar en un login que no le corresponde o que no esté validado
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restringido()
    {
        Auth::logout();
        return redirect('/');
    }

    /*
     * Pagina de Registro de Usuario
     */
    public function Register()
    {
        return view('web.register');
    }

    /*
     * Registro de usuarios y envio de mail de confirmacion
     * @param UserRequest $request
     * @throws \ArangoDBClient\Exception
     */
    public function RegisterSave(UserRequest $request)
    {

        // Revisando si existe el usuario
        $cursor = $this->CollectionHandler->byExample('users', ['email' => $request->get('email')]);
        $usuario = $this->ArangoDB->Document($cursor->getAll());
        if($usuario){
            return redirect()->action('HomeController@Register')->with('error','1')->withInput();
        }

        $data =[
            'nombre'            => $request->get('nombre'),
            'apellidos'         => $request->get('apellidos'),
            'email'             => $request->get('email'),
            'telefono'          => $request->get('telefono'),
            'password'          => $request->get('password'),
            'email_token'       => str_random(25),
        ];

        // create a document with some attributes
        $document = new ArangoDocument();
        $document->set("nombre", $data['nombre']);
        $document->set("apellidos",   $data['apellidos']);
        $document->set("telefono",   $data['telefono']);
        $document->set("email",   $data['email']);
        $document->set("email_token", $data['email_token']);
        $document->set("isAdmin", 0);
        $document->set("validated", 0);
        $document->set("active", 1);
        $document->set("created_time", now());
        $document->set("password", Hash::make($data['password']));

        $nombre = $data['nombre'].' '.$data['apellidos'];

        // save document in collection
        $documentId = $this->DocumentHandler->save('users', $document);

        // Enviando mail de confirmación con el token del usuario
        Mail::to($data['email'])
            ->queue(new ConfirmationEmail($data));

        return view('web.usuario_registrado', compact('nombre'));
    }

    /**
     * Registrando una confirmacion y validando el token de usuario
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Confirmation($token){

        // Buscar Usuario por token
        $cursor = $this->CollectionHandler->byExample('users', ['email_token' => $token]);
        $usuario = $this->ArangoDB->Document($cursor->getAll());

        if(!$usuario){
            return view('web.confirmacion')->with('error',1);
        }else{
            $user = new ArangoDocument();
            $user->validated = 1;
            $user->email_token = null;
            $result = $this->DocumentHandler->updateById('users', $usuario->_key, $user);
            return view('web.confirmacion')
                ->with('nombre', $usuario->nombre.' '.$usuario->apellidos)
                ->with('error',0);
        }
    }

    public function Acerca(){
        return view('web.acerca-de');
    }

    public function Porque(){
        return view('web.porque');
    }

    public function Numeros(){
        return view('web.numeros');
    }

    public function Aviso(){
        return view('web.aviso-privacidad');
    }

    public function Terminos(){
        return view('web.terminos');
    }

    public function PasswordRecovery(Request $request){
        // Encontrar Usuario por email
        $cursor = $this->CollectionHandler->byExample('users', ['email' => Input::get('email')]);
        $usuario = $this->ArangoDB->Document($cursor->getAll());

        if(!$usuario){
            return redirect()->route('recover')->with('error_recover','1')->withInput();
        }else{
            $data =[
                'nombre'            => $usuario->nombre.' '.$usuario->apellidos,
                'email'             => $request->get('email'),
                'password_recover'  => str_random(25),
            ];
            // Enviando mail de confirmación con el token del usuario
            Mail::to($data['email'])
                ->queue(new RecoverPassword($data));

            // Guardando Password Token
            $user = new ArangoDocument();
            $user->password_recover = $data['password_recover' ];
            $this->DocumentHandler->updateById('users', $usuario->_key, $user);

            return view('auth.passwords.password-recovery')
                ->with('send', 1);
        }
    }
    public function PasswordRecoveryEmail($token){
        // Buscar Usuario por token
        $cursor = $this->CollectionHandler->byExample('users', ['password_recover' => $token]);
        $usuario = $this->ArangoDB->Document($cursor->getAll());

        if(!$usuario){
            return view('auth.passwords.reset')->with('error',1);
        }else{
            return view('auth.passwords.reset')
                ->with('error',0)
                ->with('token', $token);
        }
    }

    public function PasswordRecoveryUpdate(PasswordRequest $request){
        // Buscar Usuario por token
        $cursor = $this->CollectionHandler->byExample('users', ['password_recover' => $request->get('token')]);
        $usuario = $this->ArangoDB->Document($cursor->getAll());

        if(!$usuario){
            return view('auth.passwords.reset')->with('error',1);
        }else{
            $user = new ArangoDocument();
            $user->password_recover = null;
            $user->password = Hash::make($request->get('password'));
            $this->DocumentHandler->updateById('users', $usuario->_key, $user);

            return view('auth.passwords.reset')
                ->with('error',0)
                ->with('correcto', 1);
        }
    }
}
