<?php

namespace App\Libraries;

use Hashids\Hashids;

class Hasher
{
    public static function encode(...$args)
    {
        return app(Hashids::class)->encode(...$args);
    }
    public static function decode($enc)
    {
        if (is_int($enc)) {
            return $enc;
        }

        if(isset(app(Hashids::class)->decode($enc)[0]))
        {
            return app(Hashids::class)->decode($enc)[0];
        }
        else
        {
            return false;
        }
    }
}