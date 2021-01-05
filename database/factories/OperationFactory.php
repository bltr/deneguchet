<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Operation;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Operation create($attributes = [], ?Model $parent = null)
 * @method Operation make($attributes = [], ?Model $parent = null)
 */
class OperationFactory extends Factory
{
    protected $model = Operation::class;

    public function definition()
    {
        return [
            'amount' => -1000,
            'category_id' => Category::factory()->expense(),
            'type' => Type::EXPENSE(),
        ];
    }

    public function income(int $amount)
    {
        return $this->state(function (array $attributes) use ($amount) {
            return [
                'amount' => $amount,
                'category_id' => Category::factory()->income(),
                'type' => Type::INCOME(),
            ];
        });
    }

    public function expense(int $amount)
    {
        return $this->state(function (array $attributes) use ($amount){
            return [
                'amount' => -$amount,
                'category_id' => Category::factory()->expense(),
                'type' => Type::EXPENSE(),
            ];
        });
    }
}
