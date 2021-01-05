<?php

namespace App\Models;

abstract class Enum
{
    private string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function equal(self $instance): bool
    {
        return $instance instanceof static && $this->value === $instance->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
