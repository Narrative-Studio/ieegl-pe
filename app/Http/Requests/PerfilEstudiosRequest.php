<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PerfilEstudiosRequest extends FormRequest
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
                        'actualmente_cursando_carrera'  => 'required',
                        'fecha_graduacion'              => 'required|date',
                    ];
                    if (Request::input('universidad_otra') == '') {
                        $rules['universidad']      = 'required';
                    }
                    if (Request::input('universidad') == '' && Request::input('universidad_otra') != '') {
                        $rules['universidad_otra']      = 'required';
                    }
                    return $rules;
                    break;
                }

            default:break;
        }
    }
}
