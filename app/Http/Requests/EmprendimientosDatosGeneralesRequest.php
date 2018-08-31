<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosDatosGeneralesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'PUT':
                {
                    $rules =  [
                        'nombre'             => 'required|max:255',
                        'descripcion'             => 'required|max:140',
                        'numero_colaboradores'                  => 'required',
                        'pais'                  => 'required',
                        'ciudad'                => 'required',
                        'industria_o_sector'                => 'required',
                        'etapa_emprendimiento'                => 'required',
                        'mercado_cliente'                => 'required',
                        'problema_soluciona'                => 'required',
                        'competencia'                => 'required',
                        'diferencia_competencia'                => 'required',
                        'diferenciador_modelo_negocio'                => 'required',
                        'investigacion_desarrollo'                => 'required',
                        'numero_socios'                => 'required',
                        'prototipo_o_mvp'                => 'required',
                    ];
                    return $rules;
                    break;
                }
            case 'POST':
                {
                    $rules =  [
                        'biografia'             => 'required|max:140',
                        'sexo'                  => 'required',
                        'fecha_nacimiento'      => 'required|date',
                        'a_que_se_dedica'       => 'required',
                        'pais'                  => 'required',
                        'ciudad'                => 'required',
                    ];
                    if (Request::input('pais') != '121') {
                        $rules['estado_otro']      = 'required';
                    }else{
                        $rules['estado']      = 'required';
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
