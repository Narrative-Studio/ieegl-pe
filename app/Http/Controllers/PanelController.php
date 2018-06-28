<?php

namespace App\Http\Controllers;

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
        //Obteniendo perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        if(count($data)<1){
            return redirect()->action('PanelPerfiles@Index');
        }else{
            return view('panel.dashboard');
        }
    }
}