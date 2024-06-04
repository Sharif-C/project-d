<?php

namespace App\Utils\Api\Enums;

enum ProductLocation : string
{
    case WAREHOUSE = "warehouse";
    case VAN = "van";


    public static function stringExists(string $productLocation): bool{
        $productLocation = strtolower($productLocation); // makes lowercase

        foreach (self::cases() as $case) {
            if ($productLocation !== $case->value) continue;

            if ($productLocation === $case->value) return true;
        }

        return false;
    }
}
