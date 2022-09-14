<?php

namespace App\Domain\Order\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self completed()
 * @method static self cancelled()
 */
class OrderStatus extends Enum
{
}
