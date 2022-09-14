<?php

namespace App\Support;

interface MorphableModel
{
    /**
     * @return mixed
     */
    public function getKey();

    /**
     * @return mixed
     */
    public function getMorphClass();
}
