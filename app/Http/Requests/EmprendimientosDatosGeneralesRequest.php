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
                        'fecha_fundacion'                  => 'required|date',
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
                    ];
                    if (Request::input('como_te_enteraste') != '') {
                        $rules['como_te_enteraste_cual']      = 'required';
                    }
                    return $rules;
                    break;
                }
            case 'POST':
            default:break;
        }
    }
}
