<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    public function user_can_see_all()
    {
        $response = $this->withHeaders($this->headers($this->user()))->json('GET','api/permission');
        $response->assertStatus(200);
    }
}
