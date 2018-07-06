<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $paises = ["Afganistan","Albania","Alemania","Andorra","Angola","Antartida","Antigua y Barbuda","Arabia Saudi","Argelia","Argentina","Armenia","Australia","Austria","Azerbaiyan","Bahamas","Bahrain","Bangladesh","Barbados","Belgica","Belice","Benin","Bermudas","Bielorrusia","Birmania Myanmar","Bolivia","Bosnia y Herzegovina","Botswana","Brasil","Brunei","Bulgaria","Burkina Faso","Burundi","Butan","Cabo Verde","Camboya","Camerun","Canada","Chad","Chile","China","Chipre","Colombia","Comores","Congo","Corea del Norte","Corea del Sur","Costa de Marfil","Costa Rica","Croacia","Cuba","Dinamarca","Dominica","Ecuador","Egipto","El Salvador","El Vaticano","Emiratos arabes Unidos","Eritrea","Eslovaquia","Eslovenia","España","Estados Unidos","Estonia","Etiopia","Filipinas","Finlandia","Fiji","Francia","Gabon","Gambia","Georgia","Ghana","Gibraltar","Granada","Grecia","Guam","Guatemala","Guinea","Guinea Ecuatorial","Guinea Bissau","Guyana","Haiti","Honduras","Hungria","India","Indian Ocean","Indonesia","Iran","Iraq","Irlanda","Islandia","Israel","Italia","Jamaica","Japon","Jersey","Jordania","Kazajstan","Kenia","Kirguistan","Kiribati","Kuwait","Laos","Lesoto","Letonia","Libano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macedonia","Madagascar","Malasia","Malawi","Maldivas","Mali","Malta","Marruecos","Mauricio","Mauritania","Mexico","Micronesia","Moldavia","Monaco","Mongolia","Montserrat","Mozambique","Namibia","Nauru","Nepal","Nicaragua","Niger","Nigeria","Noruega","Nueva Zelanda","Oman","Paises Bajos","Pakistan","Palau","Panama","Papua Nueva Guinea","Paraguay","Peru","Polonia","Portugal","Puerto Rico","Qatar","Reino Unido","Republica Centroafricana","Republica Checa","Republica Democratica del Congo","Republica Dominicana","Ruanda","Rumania","Rusia","Sahara Occidental","Samoa","San Cristobal y Nevis","San Marino","San Vicente y las Granadinas","Santa Lucia","Santo Tome y Principe","Senegal","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Southern Ocean","Sri Lanka","Swazilandia","Sudafrica","Sudan","Suecia","Suiza","Surinam","Tailandia","Taiwan","Tanzania","Tayikistan","Togo","Tokelau","Tonga","Trinidad y Tobago","Tunez","Turkmekistan","Turquia","Tuvalu","Ucrania","Uganda","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Yemen","Djibouti","Zambia","Zimbabue" ];
    public $nivel_tlr = ["TRL Nivel 1","TRL Nivel 2","TRL Nivel 3","TRL Nivel 4","TRL Nivel 5","TRL Nivel 6","TRL Nivel 7", "TRL Nivel 8", "TRL Nivel 9"];
    public $modelos_ventas = ["B2B","B2C","B2G","C2C","No lo sé/No estoy seguro"];
    public $n_meses = ["","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
    public $meses_montos = 6;

    public function getMeses($cuantos, $time){
        $meses = [];
        for($i=0;$i<$cuantos;$i++){
            $meses[date('Y', strtotime('-'.$i.' month', $time))][] = date('n', strtotime('-'.$i.' month', $time));
        }
        $meses = array_reverse($meses, true);
        foreach($meses as $year=>$val){
            $meses[$year] = array_reverse($meses[$year], true);
        }
        return $meses;
    }
}
