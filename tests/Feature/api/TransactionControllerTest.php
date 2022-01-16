<?php

namespace Tests\Feature\api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\api\Transaction;
use Psy\CodeCleaner\FunctionContextPass;
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
        //  $this->withoutExceptionHandling();



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

        $response->assertJsonStructure(["data"=>["id", "Precio", "Egreso", "Creado"]])
            // ->assertJson(["id" => $transaction->id])
            ->assertStatus(200);
    }
    public function test_show_not_found()
    {
        // $this->withoutExceptionHandling();

        $response = $this->json("GET", "/api/transactions/1000");

        $response->assertStatus(404);
    }


    public function test_update()
    {

        $this->withoutExceptionHandling();
        $transaction = Transaction::factory()->create();

        $response = $this->json("PUT", "/api/transactions/$transaction->id", [
            "mount" => 3333.33
        ]);

        $response->assertJsonStructure(["id", "mount", "isEgress", "created_at", "updated_at"])
            ->assertJson([
                "mount" => 3333.33
            ])
            ->assertStatus(201);
    }

    public function test_delete()
    {

        // $this->withoutExceptionHandling();
        $transaction = Transaction::factory()->create();

        $response = $this->json("DELETE", "/api/transactions/$transaction->id");

        $response->assertSee(null)
            ->assertStatus(204);
        $this->assertDatabaseMissing("transactions", ["id" => $transaction->id]);
    }

    public function test_index()
    {

        // $this->withoutExceptionHandling();
        Transaction::factory()->count(10)->create();
        $response = $this->json("GET", "/api/transactions");

        $response->assertJsonStructure([
            "data" => [
                "*" => ["id", "mount", "isEgress", "created_at", "updated_at"]
            ]
        ])
            ->assertStatus(200);
    }
}
