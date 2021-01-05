<?php

namespace App\Casts;

use App\Models\Type;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TypeCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes): Type
    {
        $method = strtoupper($value);
        if (!method_exists(Type::class, $method)) {
            throw new \InvalidArgumentException();
        }

        return Type::${$method};
    }

    public function set($model, $key, $value, $attributes): string
    {
        return $value->value();
    }
}
