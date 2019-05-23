<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use Illuminate\Support\Carbon;

class PanelController extends Controller
{
    protected $ArangoDB;

    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        $this->middleware('is_user');
    }

    public function Index(){
        //$date = Carbon::now();
        //echo $date->formatLocalized('%A %d %B %Y');exit();
        //Obteniendo perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        if(count($data)<1){
            return redirect()->action('PanelPerfiles@Index');
        }else{
            $perfil = $data[0];
            $niveles = $this->nivel_tlr;
            $emprendimientos = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc.userKey == "'.auth()->user()->_key.'"  OR  "'.auth()->user()->_key.'" IN doc.socios SORT doc._key desc RETURN doc');
            return view('panel.dashboard',compact('emprendimientos','perfil','niveles'));
        }
    }
}