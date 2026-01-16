<?php

namespace App\Enums;

enum ProductSort:string
{
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case RATING_DESC = 'rating_desc';
    case NEWEST = 'newest';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
