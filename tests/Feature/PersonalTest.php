<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonalTest extends TestCase
{


    use RefreshDatabase;
    /**
     * A basic feature test example.
     */



    public function test_index(): void
    {

        $response = $this->get('/api/v1/personal');
        $response->assertStatus(200);
    }


   public function test_request_personal_should_422(): void
    {

        $response = $this->postJson('/api/v1/personal', []);

        dump($response->getContent());
        $response->assertStatus(422);
    } 



}
