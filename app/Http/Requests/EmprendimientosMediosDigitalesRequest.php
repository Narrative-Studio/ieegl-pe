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
                    ];
                    if (Request::input('logo_file')) {
                        $rules['logo']      = 'mimes:png,gif,jpg,jpeg';
                    }else{
                        $rules['logo']      = 'required|mimes:png,gif,jpg,jpeg';
                    }
                    if (Request::input('presentacion_file')) {
                        $rules['presentacion']      = 'mimes:pdf,jpg,jpeg';
                    }else{
                        $rules['presentacion']      = 'required|mimes:pdf,jpg,jpeg';
                    }

                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
