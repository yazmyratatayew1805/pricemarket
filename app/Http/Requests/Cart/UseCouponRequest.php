<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\Request;

class UseCouponRequest extends Request
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'exists:coupons,code'],
        ];
    }
}
