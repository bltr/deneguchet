<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Operation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Account create($attributes = [], ?Model $parent = null)
 * @method Account make($attributes = [], ?Model $parent = null)
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'name' => 'Наличные',
        ];
    }

    public function hasIncomes(array $amounts)
    {
        $factory = $this;
        foreach ($amounts as $amount) {
            $factory = $factory->has(Operation::factory()->income($amount));
        }

        return $factory;
    }

    public function hasExpenses(array $amounts)
    {
        $factory = $this;
        foreach ($amounts as $amount) {
            $factory = $factory->has(Operation::factory()->expense($amount));
        }

        return $factory;
    }
}
