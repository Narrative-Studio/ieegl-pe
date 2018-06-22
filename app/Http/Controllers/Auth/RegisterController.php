<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\ArangoDB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->middleware('guest');
        $this->ArangoDB = $ArangoDB;
        $this->DocumentHandler = $ArangoDB->DocumentHandler();
        $this->CollectionHandler = $ArangoDB->CollectionHandler();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|min:8',
            'email' => 'required|string|email|max:255|confirmed',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $token = str_random(20);

        // create a document with some attributes
        $document = new ArangoDocument();
        $document->set("nombre", $data['name']);
        $document->set("apellidos", $data['apellidos']);
        $document->set("telefono", $data['telefono']);
        $document->set("email", $data['email']);
        $document->set("isAdmin", "0");
        $document->set("token_confirm", $token);
        $document->set("password", Hash::make($data['password']));

        // save document in collection
        $documentId = $this->DocumentHandler->save('users', $document);
    }
}
