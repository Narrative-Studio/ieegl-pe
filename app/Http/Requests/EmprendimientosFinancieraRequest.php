<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosFinancieraRequest extends FormRequest
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
            case 'POST':
                {
                    $rules['lanzar_producto']       = 'required';
                    $rules['fecha_lanzamiento']     = 'required|date';
                    $rules['realizado_ventas']      = 'required';
                    $rules['patente_ip']            = 'required';
                    $rules['socio_exit_empresa']    = 'required';
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}