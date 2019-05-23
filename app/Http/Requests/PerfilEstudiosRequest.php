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
                    ];
                    if (Request::input('actualmente_cursando_carrera') == 'Preparatoria en el Tec' || Request::input('actualmente_cursando_carrera') == 'Licenciatura en el Tec' || Request::input('actualmente_cursando_carrera') == 'Posgrado en el Tec') {
                        $rules['campus']        = 'required';
                        $rules['matricula']     = 'required|regex:/^A\d{8}/m';
                    }
                    return $rules;
                    break;
                }

            default:break;
        }
    }
}
