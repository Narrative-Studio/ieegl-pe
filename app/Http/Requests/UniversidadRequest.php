<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversidadRequest extends FormRequest
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
                        'nombre' => 'required|max:255',
                    ];
                    break;
                }
            case 'POST':
                {
                    return [
                        'nombre' => 'required|max:255',
                    ];
                    break;
                }
            default:break;
        }
    }
}
