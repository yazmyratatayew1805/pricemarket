<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    abstract public function rules(): array;

    public function authorize()
    {
        return true;
    }
}
