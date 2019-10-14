<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class ServiceTest extends TestCase
{
    
    
    public function test_user_can_see_services()
    {
        $response = $this->addHeaders(User::find(1))->json('GET','api/service')->dump();
        $response->assertStatus(200);
    }

    public function test_user_can_add_services()
    {
        $data = [
            'name' => 'Kategoria B',
            'slug' => 'Cat-b',
            'description' => 'Kategoria B - samochody osobowe itp.',
            'defaults' => "{'cost_course':'$faker->numberBetween($min = 50, $max = 5000)','hours':'$faker->numberBetween($min = 28, $max = 32)','old_hours':'0','cost_doctor':'200'}"
        ];
        $response = $this->addHeaders(User::find(1))->json('POST','api/service',$data)->dump();
        $response->assertStatus(201);
    }

    public function test_user_can_update_services()
    {
        //poprawic
        $data = [
            'name' => 'Kategoria B2',
            'slug' => 'Cat-b2',
            'description' => 'asd',
            'defaults' => "{'cost_course':'$faker->numberBetween($min = 50, $max = 5000)','hours':'$faker->numberBetween($min = 28, $max = 32)','old_hours':'0','cost_doctor':'200'}"
        ];
        $response = $this->addHeaders(User::find(1))->json('PUT','api/service',$data)->dump();
        $response->assertStatus(201);
    }

    public function test_service_create_validation_req_name()
    {
        $service = factory('App\Service')->make(['name' => null]);
        $this->addHeaders(User::find(1))->json('POST','api/service',$service->toArray())->dump()->assertJsonValidationErrors('name');
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $this->createApplication();
        $faker = Factory::create('pl_PL');
        //$faker = $this->faker;
        //$faker = Faker\Factory::create();
        //dd($faker);
        $defaults = "{'cost_course':'{$faker->numberBetween($min = 50, $max = 5000)}','hours':'{$faker->numberBetween($min = 28, $max = 32)}','old_hours':'0','cost_doctor':'200'}";
        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => false,
                'data' => [
                    'slug' => $faker->slug,
                    'description' => $faker->paragraph,
                    'defaults' => $defaults,
                ],
                'field' => 'name'
            ],
            'request_should_fail_when_no_slug_is_provided' => [
                'passed' => false,
                'data' => [
                    'name' => $faker->word,
                    'description' => $faker->paragraph,
                    'defaults' => $defaults,
                ],
                'field' => 'slug'
            ],'request_should_fail_when_any_required_is_provided' => [
                'passed' => false,
                'data' => [],
                'field' => ['name','slug','description','defaults']
            ],'request_should_fail_when_name_slug_to_long_provided' => [
                'passed' => false,
                'data' => [
                    'name' => $faker->paragraph(3),
                    'slug' => $faker->paragraph(2),
                    'description' => $faker->paragraph,
                    'defaults' => $defaults,
                ],
                'field' => ['name','slug']
            ],'request_should_fail_when_name_slug_no_unique_provided' => [
                'passed' => false,
                'data' => [
                    'name' => 'Kategoria B',
                    'slug' => 'Cat-b',
                    'description' => 'Kategoria B - samochody osobowe itp.',
                    'defaults' => $defaults
                ],
                'field' => ['name','slug']
            ],'request_should_no_errors' => [
                'passed' => true,
                'data' => [
                    'name' => 'Kategoria C',
                    'slug' => 'Cat-c',
                    'description' => 'Kategoria C - samochody cięzarowe itp.',
                    'defaults' => $defaults
                ],
                'field' => []
            ],

        ];
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function test_service_validation($shouldPass, $mockedRequestData,$field)
    {
        $service = factory('App\Service')->make($mockedRequestData);
        $res = $this->addHeaders(User::find(1))->json('POST','api/service', $mockedRequestData)->dump();
        $shouldPass ? $res->assertStatus(201) : $res->assertJsonValidationErrors($field);
        //$this->addHeaders(User::find(1))->json('POST','api/service', $service->toArray())->dump()->assertJsonValidationErrors($field);
    }
}
