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

                    $rules =  [
                        'lanzar_producto'             => 'required',
                        'fecha_fundacion'             => 'required|date',
                        'cedula_identificacion'       => 'mimes:jpg,jpeg,pdf',
                    ];
                    if (Request::input('lanzar_producto') == 'Si') {
                        $rules['fecha_lanzamiento']      = 'required';
                        $rules['modelo_ventas']      = 'required';
                        $rules['realizado_ventas']      = 'required';
                        $rules['fecha_fundacion']      = 'required';
                        $rules['patente_ip']      = 'required';
                        $rules['socio_exit_empresa']      = 'required';
                        $rules['gasto_mensual']      = 'required';
                        $rules['pierde_dinero']      = 'required';
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}