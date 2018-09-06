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
                        'sitio_web'           => 'required',
                        'red_social'          => 'required',
                        'video'               => 'required',
                        'logo'                => 'image:jpg,jpeg,png,gif',
                        'presentacion'        => 'mimes:pdf,jpg,jpeg',
                    ];
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
