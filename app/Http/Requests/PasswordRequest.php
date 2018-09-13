<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PasswordRequest extends FormRequest
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
            case 'PUT':
            case 'POST':
                {
                    $rules = [
                        'password'  => 'required|string|min:4|max:255|confirmed',
                    ];
                    return $rules;
                    break;
                }
            default:break;
        }
    }
}
