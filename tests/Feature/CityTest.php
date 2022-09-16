<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    //     $response = $this->get('/api/city');
    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //             'id',
    //             'name',
    //             'deleted_at',
    //             'created_at',
    //             'updated_at',
    //     ]);
    }
}
