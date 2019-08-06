<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    public function test_user_can_see_services()
    {
        $response = $this->json('GET','api/service');
        $response->assertStatus(200);
    }
}
