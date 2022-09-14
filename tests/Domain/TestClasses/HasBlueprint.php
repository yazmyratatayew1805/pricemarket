<?php

namespace Tests\Domain\TestClasses;

use Illuminate\Database\Schema\Blueprint;

interface HasBlueprint
{
    public function getBlueprint(Blueprint $table): void;
}
