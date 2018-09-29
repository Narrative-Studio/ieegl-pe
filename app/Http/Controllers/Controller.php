<?php

namespace App\Http\Controllers;
setlocale(LC_TIME, 'es_ES.UTF-8');

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $paises = ["Afganistán","Albania","Alemania","Andorra","Angola","Antártida","Antigua y Barbuda","Arabia Saudí","Argelia","Argentina","Armenia","Australia","Austria","Azerbaiyán","Bahamas","Bahrain","Bangladesh","Barbados","Bélgica","Belice","Benin","Bermudas","Bielorrusia","Birmania Myanmar","Bolivia","Bosnia y Herzegovina","Botswana","Brasil","Brunei","Bulgaria","Burkina Faso","Burundi","Bután","Cabo Verde","Camboya","Camerún","Canada","Chad","Chile","China","Chipre","Colombia","Comores","Congo","Corea del Norte","Corea del Sur","Costa de Marfil","Costa Rica","Croacia","Cuba","Dinamarca","Dominica","Ecuador","Egipto","El Salvador","El Vaticano","Emiratos Arabes Unidos","Eritrea","Eslovaquia","Eslovenia","España","Estados Unidos","Estonia","Etiopía","Filipinas","Finlandia","Fiji","Francia","Gabón","Gambia","Georgia","Ghana","Gibraltar","Granada","Grecia","Guam","Guatemala","Guinea","Guinea Ecuatorial","Guinea Bissau","Guyana","Haití","Honduras","Hungría","India","Indian Ocean","Indonesia","Irán","Iraq","Irlanda","Islandia","Israel","Italia","Jamaica","Japón","Jersey","Jordania","Kazajstán","Kenia","Kirguistán","Kiribati","Kuwait","Laos","Lesoto","Letonia","Líbano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macedonia","Madagascar","Malasia","Malawi","Maldivas","Mali","Malta","Marruecos","Mauricio","Mauritania","México","Micronesia","Moldavia","Mónaco","Mongolia","Montserrat","Mozambique","Namibia","Nauru","Nepal","Nicaragua","Niger","Nigeria","Noruega","Nueva Zelanda","Omán","Paises Bajos","Pakistán","Palau","Panamá","Papua Nueva Guinea","Paraguay","Perú","Polonia","Portugal","Puerto Rico","Qatar","Reino Unido","República Centroafricana","República Checa","República Democrática del Congo","República Dominicana","Ruanda","Rumania","Rusia","Sahara Occidental","Samoa","San Cristobal y Nevis","San Marino","San Vicente y las Granadinas","Santa Lucía","Santo Tome y Príncipe","Senegal","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Southern Ocean","Sri Lanka","Swazilandia","Sudáfrica","Sudán","Suecia","Suiza","Surinam","Tailandia","Taiwán","Tanzania","Tayikistán","Togo","Tokelau","Tonga","Trinidad y Tobago","Túnez","Turkmekistán","Turquía","Tuvalu","Ucrania","Uganda","Uruguay","Uzbekistán","Vanuatu","Venezuela","Vietnam","Yemen","Djibouti","Zambia","Zimbabue" ];
    public $nivel_tlr = ["TRL Nivel 1","TRL Nivel 2","TRL Nivel 3","TRL Nivel 4","TRL Nivel 5","TRL Nivel 6","TRL Nivel 7", "TRL Nivel 8", "TRL Nivel 9"];
    public $modelos_ventas = ["B2B","B2C","B2G","C2C","No lo sé/No estoy seguro"];
    public $n_meses = ["","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
    public $vehiculos_inversion = ['1'=>'Directo por Equity','2'=>'Nota Convertible','3'=>'Kiss Note', '4'=>'SACE', '5'=>'ABACO'];
    public $campus = [6=>"Aguascalientes", 8=>"Chiapas", 1=>"Chihuahua", 2=>"Ciudad Juarez", 10=>"Ciudad Obregón", 9=>"Ciudad de México",11=>"Cuernavaca",12=>"Estado de México",13=>"Guadalajara",14=>"Hidalgo",15=>"Irapuato",3=>"Laguna",16=>"León",0=>"Monterrey",17=>"Morelia",18=>"Puebla",19=>"Querétaro",4=>"Saltillo",20=>"San Luis Potosí",21=>"Santa Fe",22=>"Sinaloa",23=>"Sonora Norte",5=>"Tampico",24=>"Toluca",7=>"Veracruz",25=>"Zacatecas"];
    public $estados = ['1' => 'Aguascalientes','2' => 'Baja California','3' => 'Baja California Sur','4' => 'Campeche','5' => 'Chiapas','6' => 'Chihuahua','7' => 'Coahuila de Zaragoza','8' => 'Colima','9' => 'Ciudad de México','10' => 'Durango','11' => 'Guanajuato','12' => 'Guerrero','13' => 'Hidalgo','14' => 'Jalisco','15' => 'Estado de Mexico','16' => 'Michoacan de Ocampo','17' => 'Morelos','18' => 'Nayarit','19' => 'Nuevo Leon','20' => 'Oaxaca','21' => 'Puebla','22' => 'Queretaro de Arteaga','23' => 'Quintana Roo','24' => 'San Luis Potosi','25' => 'Sinaloa','26' => 'Sonora','27' => 'Tabasco','28' => 'Tamaulipas','29' => 'Tlaxcala','30' => 'Veracruz','31' => 'Yucatan','32' => 'Zacatecas'];
    public $meses_montos = 3;

    public function getMeses($cuantos, $time){
        $meses = [];
        for($i=1;$i<=$cuantos;$i++){
            $meses[date('Y', strtotime('-'.$i.' month', $time))][] = date('n', strtotime('-'.$i.' month', $time));
        }
        $meses = array_reverse($meses, true);
        foreach($meses as $year=>$val){
            $meses[$year] = array_reverse($meses[$year], true);
        }
        return $meses;
    }
}
