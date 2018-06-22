<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    return [
                        'nombre'                    => 'required|string|max:255',
                        'apellidos'                 => 'required|string|max:255',
                        'telefono'                  => 'required|min:8',
                        'email'                     => 'required|string|email|max:255|confirmed',
                        'password'                  => 'required|string|min:4|max:255|confirmed',
                        'g-recaptcha-response'      => 'required|recaptcha',
                        'terminos_y_condiciones'    => 'required|accepted'
                    ];
                    break;
                }
            case 'POST':
                {
                    return [
                        'nombre'                    => 'required|string|max:255',
                        'apellidos'                 => 'required|string|max:255',
                        'telefono'                  => 'required|min:8',
                        'email'                     => 'required|string|email|max:255|confirmed',
                    ];
                    break;
                }
            default:break;
        }
    }
}
