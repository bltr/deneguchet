<?php


namespace App\Models;


class Type extends Enum
{
    public static function INCOME(): self
    {
        return new static('income');
    }

    public static function EXPENSE(): self
    {
        return new static('expense');
    }
}
