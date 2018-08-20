<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ConvocatoriasRequest extends FormRequest
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
                        'descripcion'             => 'required',
                        'descripcion_corta'             => 'required|max:255',
                        'entidad'             => 'required',
                        'quien'             => 'required',
                        'responsable'             => 'required',
                        'ventas'             => 'required',
                        'clientes'             => 'required',
                        'financiera'             => 'required',
                        'activo'             => 'required',
                        'pago'             => 'required',
                        'fecha_inicio_convocatoria'      => 'required|date',
                        'fecha_fin_convocatoria'                  => 'required',
                        'fecha_inicio_evento'                  => 'required',
                        'fecha_fin_evento'                  => 'required',
                        'imagen'                => 'image:jpg,jpeg',
                    ];
                    return $rules;
                    break;
                }
            case 'POST':
                {
                    $rules =  [
                        'nombre'             => 'required|max:255',
                        'descripcion'             => 'required',
                        'descripcion_corta'             => 'required|max:255',
                        'entidad'             => 'required',
                        'quien'             => 'required',
                        'responsable'             => 'required',
                        'ventas'             => 'required',
                        'clientes'             => 'required',
                        'financiera'             => 'required',
                        'activo'             => 'required',
                        'pago'             => 'required',
                        'fecha_inicio_convocatoria'      => 'required|date',
                        'fecha_fin_convocatoria'                  => 'required',
                        'fecha_inicio_evento'                  => 'required',
                        'fecha_fin_evento'                  => 'required',
                    ];
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
