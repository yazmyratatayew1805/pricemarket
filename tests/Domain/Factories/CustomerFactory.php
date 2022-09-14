<?php

namespace Tests\Domain\Factories;

use App\Domain\Customer\Customer;
use App\Models\User;

class CustomerFactory
{
    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): Customer
    {
        $user = User::factory()->create();

        return Customer::create(
            [
                'user_id' => $user->id,
                'name' => 'Brent',
                'email' => 'brent@spatie.be',
            ] + $extra
        );
    }
}
