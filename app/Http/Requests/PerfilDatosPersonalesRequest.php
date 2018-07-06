<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PerfilDatosPersonalesRequest extends FormRequest
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
                        'biografia'             => 'required|max:140',
                        'sexo'                  => 'required',
                        'fecha_nacimiento'      => 'required|date',
                        'a_que_se_dedica'       => 'required',
                        'pais'                  => 'required',
                        'ciudad'                => 'required',
                    ];
                    if (Request::input('pais') != '121') {
                        $rules['estado_otro']      = 'required';
                    }else{
                        $rules['estado']      = 'required';
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
