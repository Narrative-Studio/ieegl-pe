<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosUsuariosRequest extends FormRequest
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
                        'tiene_usuarios'             => 'required',
                    ];
                    if (Request::input('tiene_usuarios') == 'Si') {
                        $rules['caracteristicas_usuarios']      = 'required';
                    }
                    return $rules;
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
