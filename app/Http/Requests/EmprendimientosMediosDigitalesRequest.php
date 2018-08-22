<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosMediosDigitalesRequest extends FormRequest
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
                        'logo'                => 'image:jpg,jpeg',
                        'presentacion'                => 'mimes:pdf',
                    ];
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
