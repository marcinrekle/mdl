<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class ServiceTest extends TestCase
{
    public function test_user_can_see_services()
    {
        $response = $this->json('GET','api/service');
        $response->assertStatus(200);
    }

    public function test_user_can_add_services()
    {
        $data = [
            'name' => 'Kategoria B',
            'slug' => 'Cat-b',
            'description' => '',
            'defaults' => '{"cost_course":"$faker->numberBetween($min = 50, $max = 5000)","hours":"$faker->numberBetween($min = 28, $max = 32)","old_hours":"0","cost_doctor":"200"}'
        ];
        $response = $this->json('POST','api/service',$data);
        $response->assertStatus(201);
    }

    public function test_user_can_update_services()
    {
        //poprawic
        $data = [
            'name' => 'Kategoria B2',
            'slug' => 'Cat-b2',
            'description' => 'asd',
            'defaults' => '{"cost_course":"$faker->numberBetween($min = 50, $max = 5000)","hours":"$faker->numberBetween($min = 28, $max = 32)","old_hours":"0","cost_doctor":"200"}'
        ];
        $response = $this->json('PUT','api/service',$data);
        $response->assertStatus(201);
    }

    public function test_service_create_validation_req_name()
    {
        $service = factory('App\Service')->make(['name' => null]);
        $this->addHeaders(User::find(1))->json('POST','api/service',$service->toArray())->dump()->assertSessionHasErrors('name');
    }
}
