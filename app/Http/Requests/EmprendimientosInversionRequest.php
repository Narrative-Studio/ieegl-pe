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
                        'levantado_capital'             => 'required',
                        'recibido_inversion'             => 'required',
                        'buscando_capital'             => 'required',
                    ];
                    /*if (Request::input('recibido_inversion') == 'Si') {
                        $rules['recibido_inversion_dequien']      = 'required';
                        $rules['recibido_inversion_cuanto']      = 'required';
                        $rules['recibido_inversion_como']      = 'required';
                        $rules['recibido_inversion_fecha_levantaron_capital']      = 'date|required';
                        $rules['recibido_inversion_vehiculo']      = 'required';
                    }
                    if (Request::input('buscando_capital') == 'Si') {
                        $rules['capital_cuanto']      = 'required';
                        $rules['vehiculo_inversion']      = 'required';
                    }*/
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
