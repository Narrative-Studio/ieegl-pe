<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosMercadoRequest extends FormRequest
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
                        'tiene_clientes'             => 'required',
                        'tiene_usuarios'             => 'required',
                    ];
                    if (Request::input('tiene_clientes') == 'Si') {
                        $rules['caracteristicas_clientes']      = 'required';
                    }
                    if (Request::input('tiene_usuarios') == 'Si') {
                        $rules['caracteristicas_usuarios']      = 'required';
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
