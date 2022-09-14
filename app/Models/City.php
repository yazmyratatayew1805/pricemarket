<?php

namespace App\Models;
use App\Domain\Product\Product;
use Database\Factories\CityFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';


    protected static function newFactory(): CityFactory
    {
        return new CityFactory();
    }

    public function product(){
        return $this->hasMany(Product::class);
    }
}
