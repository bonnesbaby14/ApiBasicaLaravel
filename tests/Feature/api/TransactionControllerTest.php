<?php

namespace Tests\Feature\api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $response = $this->json("POST", "/api/transactions", [
            "mount" => 123.6,
        ]);


        $response->assertJsonStructure(["id", "mount", "created_at", "updated_at"])
            ->asserJson(["mount" => 123.6])
            ->asserStatus(201);

        $this->assertDatabaseHas("transations", ["mount" => 123.6]);
    }
}
