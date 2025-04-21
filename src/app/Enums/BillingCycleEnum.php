<?php

namespace App\Enums;

enum BillingCycleEnum: string
{
    case WEEKLY  = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY  = 'yearly';

    public function label(): string
    {
        return match ($this) {
            self::WEEKLY  => 'Weekly',
            self::MONTHLY => 'Monthly',
            self::YEARLY  => 'Yearly',
        };
    }
}
