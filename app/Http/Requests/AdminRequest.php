<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
                return [
                    'nombre'                    => 'required|string|max:255',
                    'apellidos'                 => 'required|string|max:255',
                    'email'                     => 'required|string|email|max:255',
                    'password'                  => 'required',
                    'rol_id'                    => 'required',
                    'activo'                    => 'activo',
                ];
            case 'POST':
                {
                    return [
                        'nombre'                    => 'required|string|max:255',
                        'apellidos'                 => 'required|string|max:255',
                        'email'                     => 'required|string|email|max:255',
                        'rol_id'                     => 'required',
                        'activo'                    => 'activo',
                    ];
                    break;
                }
            default:break;
        }
    }
}
