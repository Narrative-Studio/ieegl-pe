<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EmprendimientosInversionRequest extends FormRequest
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
                        'invertido_capital'             => 'required',
                    ];
                    if (Request::input('invertido_capital') == 'Si') {
                        $rules['inversion_otras']      = 'required';
                        $rules['buscando_capital']      = 'required';

                        if (Request::input('inversion_otras') == 'Si') {
                            $rules['capital_otros']      = 'required';
                        }
                    }
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
