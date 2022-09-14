<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\Request;

class CheckoutRequest extends Request
{
    public function rules(): array
    {
        return [
            'street' => ['required', 'string'],
            'number' => ['required', 'string'],
            'postal' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
        ];
    }
}
