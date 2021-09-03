<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
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
    }

    public function testCreateProductWithMiddleware()
        {
                $data = [
                        'name' => "New Product",
                        'manufacture_year' => 1992,
                        'image' => "https://images.pexels.com/photos/1000084/pexels-photo-1000084.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
                               ];

            $response = $this->json('POST', '/api/products',$data);
            $response->assertStatus(401);
            $response->assertJson(['message' => "Unauthenticated."]);
        }
}
