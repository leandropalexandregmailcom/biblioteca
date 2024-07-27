<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_loans()
    {
        $user = User::factory()->create();
        Loan::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/loanIndex');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_new_loan()
    {
        $user = User::factory()->create();
        $loanData = Loan::factory()->make(['loan_date' => now()])->toArray();

        $response = $this->actingAs($user)->postJson('/api/loanStore', $loanData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('loans', $loanData);
    }

    public function test_it_can_show_a_specific_loan()
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/api/loanShow/{$loan->id}");

        $response->assertStatus(200);
        $response->assertJson(['data' => ['id' => $loan->id]]);
    }

    public function test_it_can_update_a_loan()
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create(['user_id' => $user->id]);
        $updateData = [
            'book_id' => $loan->book_id, // Incluir o campo book_id
            'return_date' => now()->addDays(7)->format('Y-m-d') // Corrigir o formato da data
        ];

        $response = $this->actingAs($user)->putJson("/api/loanUpdate/{$loan->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'return_date' => $updateData['return_date']
        ]);
    }

    public function test_it_can_delete_a_loan()
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/loanDestroy/{$loan->id}");

        $response->assertStatus(204);

        // Verifique se o registro foi marcado como excluído (soft delete)
        $this->assertSoftDeleted('loans', ['id' => $loan->id]);
    }
}
