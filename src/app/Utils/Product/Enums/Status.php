<?php

namespace App\Utils\Product\Enums;

enum Status:string
{
    case STORED = 'stored';
    case DISPATCHED = 'dispatched';
    case INSTALLED = 'installed';
    case LOST = 'lost';
    case DEFECT = 'defect';


    public static function labelColor(string $status) : string {
        $status = strtolower($status);

        return match($status){
            self::STORED->value => "bg-indigo-300",
            self::DISPATCHED->value => "bg-orange-300",
            self::INSTALLED->value => "bg-green-300",
            self::LOST->value => "bg-slate-500",
            self::DEFECT->value => "bg-rose-300",
            default => "bg-gray-300",
        };
    }
}
