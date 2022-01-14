<?php

namespace Tests\Feature\api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\api\Transaction;

use Tests\TestCase;


class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_store()
    {
        $this->withoutExceptionHandling();
        $response = $this->json("POST", "/api/transactions", [
            "mount" => 123.6,
            "isEgress" => true,
        ]);


        $response->assertJsonStructure(["id", "mount", "isEgress", "created_at", "updated_at"])
            ->assertJson(["mount" => 123.6])
            ->assertStatus(201);

        $this->assertDatabaseHas("transactions", ["mount" => 123.6]);
    }

    public function test_validate_mount()
    {
        $response = $this->json("POST", "/api/transactions", [
            "mount" => null
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor("mount");
    }

    public function test_show()
    {
        $this->withoutExceptionHandling();

        $transaction = Transaction::factory()->create();

        $response = $this->json("GET", "/api/transactions/$transaction->id");

        $response->assertJsonStructure(["id", "mount", "isEgress", "created_at", "updated_at"])
            ->assertJson(["id" => $transaction->id])
            ->assertStatus(200);
    }
}
