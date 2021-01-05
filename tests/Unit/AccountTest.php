<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function balance_calculating()
    {
        $account_without_operations = Account::factory()->create();
        $account_with_operations = Account::factory()
            ->hasIncomes([5000, 1500])
            ->hasExpenses([1000, 500])
            ->create();

        $balance_without_operations = $account_without_operations->balance();
        $balance_with_operations = $account_with_operations->balance();

        assertEquals(0, $balance_without_operations);
        assertEquals(5000, $balance_with_operations);
    }

    /** @test */
    public function adding_an_expense()
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        $account->addExpense(Category::factory()->expense()->create(), 100);

        assertEquals(900, $account->balance());
    }

    /**
     * @test
     * @dataProvider incorrect_amounts
     */
    public function adding_an_expense_less_than_or_equal_to_zero_throws_an_exception($amount)
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        try {
            $account->addExpense(Category::factory()->expense()->create(), $amount);
        } catch (\DomainException $e) {
            assertEquals(1000, $account->balance());
            return;
        }

        $this->fail('An expense less than or equal to zero was added, but an exception was not thrown.');
    }

    /** @test */
    public function adding_an_expense_with_category_not_for_expenses_throws_an_exception()
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        try {
            $account->addExpense(Category::factory()->income()->create(), 100);
        } catch (\DomainException $e) {
            assertEquals(1000, $account->balance());
            return;
        }

        $this->fail('An expense with category not for expenses was added, but an exception was not thrown.');
    }

    /** @test */
    public function adding_an_expense_greater_than_balance_throws_an_exception()
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        try {
            $account->addExpense(Category::factory()->expense()->create(), 1100);
        } catch (\DomainException $e) {
            assertEquals(1000, $account->balance());
            return;
        }

        $this->fail('An expense greater than balance was added, but an exception was not thrown.');
    }

    /** @test */
    public function adding_an_income()
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        $account->addIncome(Category::factory()->income()->create(), 1000);

        assertEquals(2000, $account->balance());
    }

    /**
     * @test
     * @dataProvider incorrect_amounts
     */
    public function adding_an_income_less_than_or_equal_to_zero_throws_an_exception($amount)
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        try {
            $account->addIncome(Category::factory()->income()->create(), $amount);
        } catch (\DomainException $e) {
            assertEquals(1000, $account->balance());
            return;
        }

        $this->fail('An income less than or equal to zero was added, but an exception was not thrown.');
    }

    /** @test */
    public function adding_an_income_with_category_not_for_incomes_throws_an_exception()
    {
        $account = Account::factory()->hasIncomes([1000])->create();

        try {
            $account->addIncome(Category::factory()->expense()->create(), 100);
        } catch (\DomainException $e) {
            assertEquals(1000, $account->balance());
            return;
        }

        $this->fail('An income with category not for incomes was added, but an exception was not thrown.');
    }

    public function incorrect_amounts(): array
    {
        return ['amount = 0' => [0], 'amount = -100' => [-100]];
    }
}
