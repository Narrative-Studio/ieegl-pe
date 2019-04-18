<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PreguntasRequest extends FormRequest
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
                    $rules = [
                        'pregunta' => 'required',
                        'tipo' => 'required',
                        'categoria' => 'required',
                    ];
                    if (Request::input('tipo') == 'combo' || Request::input('tipo')=='multiple') {
                        $rules['respuestas'] = 'required';
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
