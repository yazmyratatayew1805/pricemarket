<?php

namespace Tests\Domain\TestClasses;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static static create(array $input = [])
 */
abstract class BaseModel extends Model implements HasBlueprint
{
    protected $guarded = [];
}
