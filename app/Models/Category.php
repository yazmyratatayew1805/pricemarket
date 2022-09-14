<?php

namespace App\Models;
use App\Domain\Product\Product;
use Database\Factories\CategoryFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    
    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory();
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

}
