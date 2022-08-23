<?php

declare(strict_types=1);

namespace Ikuzo\SyliusMatomoPlugin\EventListener;

trait FormatAmountTrait
{
    protected static function formatAmount(int $amount): float
    {
        return (float)round($amount / 100, 2);
    }
}
