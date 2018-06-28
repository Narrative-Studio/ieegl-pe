<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                    return [
                        'biografia'             => 'required|max:140',
                        'sexo'                  => 'required',
                        'fecha_nacimiento'      => 'required|date',
                        'a_que_se_dedica'       => 'required',
                        'pais'                  => 'required',
                        'estado'                => 'required',
                        'ciudad'                => 'required',
                    ];
                    break;
                }
            default:break;
        }
    }
}
