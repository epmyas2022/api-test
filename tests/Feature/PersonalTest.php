<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonalTest extends TestCase
{



    /**
     * A basic feature test example.
     */



    public function test_index(): void
    {

        $response = $this->get('/api/v1/personal');
        $response->assertStatus(200);
    }


    public function test_store(): void
    {
        $response = $this->post('/api/v1/personal', [
            "first_name" => "sssssss",
            "last_name"  => "sssss",
            "email" => "test@gmail.com",
            "gender" => "M",
            "ip_address" => "10.167.241.208",
            "country" => "El Salvador",
            "language" => "English",
            "test" => "ssss"
        ]);
        $response->assertStatus(201);
    }

    public function test_update(): void
    {
        $response = $this->put('/api/v1/personal/1', [
            "first_name" => "sssssss",
        ]);

        $response->assertStatus(200);
    }
}
