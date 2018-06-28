<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
                    return [
                        'nombre'                    => 'required|string|max:255',
                        'apellidos'                 => 'required|string|max:255',
                        'telefono'                  => 'required|min:8',
                        'email'                     => 'required|string|email|max:255',
                    ];
                    break;
                }
            default:break;
        }
    }
}
