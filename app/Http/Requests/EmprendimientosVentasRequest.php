<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosVentasRequest extends FormRequest
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
                    ];
                    if (Request::input('lanzar_producto') == 'Si') {
                        $rules['fecha_lanzamiento']      = 'required';
                        $rules['modelo_ventas']      = 'required';
                        $rules['realizado_ventas']      = 'required';
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
