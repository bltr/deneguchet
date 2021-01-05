<?php

namespace App\Models;

use Database\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static AccountFactory factory()
 */
class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }

    public function balance(): int
    {
        return $this->operations()->sum('amount');
    }

    public function addExpense(Category $category, int $amount): void
    {
        if (!$category->type->equal(Type::EXPENSE())) {
            throw new \DomainException('Trying to add an expense with category not for expenses');
        }
        if ($amount <= 0) {
            throw new \DomainException('Trying to add an expense less than or equal to zero');
        }
        if ($amount > $this->balance()) {
            throw new \DomainException('Trying to add an expense greatest than balance');
        }

        $this->operations()->create([
            'amount' => -$amount,
            'type' => Type::EXPENSE(),
            'category_id' => $category->id,
        ]);
}

    public function addIncome(Category $category, int $amount): void
    {
        if (!$category->type->equal(Type::INCOME())) {
            throw new \DomainException('Trying to add an income with category not for incomes');
        }
        if ($amount <= 0) {
            throw new \DomainException('Trying to add an income less than or equal to zero');
        }

        $this->operations()->create([
            'amount' => $amount,
            'type' => Type::INCOME(),
            'category_id' => $category->id,
        ]);
    }
}
