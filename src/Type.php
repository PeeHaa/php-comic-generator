<?php declare(strict_types=1);

namespace PeeHaa\PHPComicGenerator;

use MyCLabs\Enum\Enum;

class Type extends Enum
{
    const __default = self::NEUTRAL;

    const NEUTRAL = 'neutral.png';
    const ANGRY   = 'angry.png';
    const SAD     = 'sad.png';
}
