<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Category create($attributes = [], ?Model $parent = null)
 * @method Category make($attributes = [], ?Model $parent = null)
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => 'Квартплата',
            'type' => Type::EXPENSE(),
        ];
    }

    public function income()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Зарплата',
                'type' => Type::INCOME(),
            ];
        });
    }

    public function expense()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Квартплата',
                'type' => Type::EXPENSE(),
            ];
        });
    }
}
