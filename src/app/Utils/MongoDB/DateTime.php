<?php

namespace App\Utils\MongoDB;

class DateTime
{
    public static function current()
    {
        return new \MongoDB\BSON\UTCDateTime(new \DateTime('now'));
    }
//    This returns a UTCDateTime object that can be converted to a readable string like this: self::current()->toDateTime()?->format('d-m-Y H:i:s')
}
