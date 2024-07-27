<?php


namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
        ];
    }
}
