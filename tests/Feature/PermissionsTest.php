<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Permission;

class PermissionsTest extends TestCase
{

    public $user = 1;
    public $pid = 0;

    private function user()
    {
        return User::find($this->user);
    }

    public function test_user_can_see_permissions()
    {
        $response = $this->withHeaders($this->headers($this->user()))->json('GET','api/permission');
        $response->assertStatus(200);
    }

    public function test_user_can_create_permissions()
    {
        $response = $this->withHeaders($this->headers($this->user()))->json('POST','api/permission',['name' => 'Test','display_name' => 'Test dispname','description' => 'Opis','groupName' => 'Test']);
        //dd($response);
        $response->assertStatus(201);
    }

    public function test_user_can_update_permissions()
    {
        $perm = Permission::whereName('Test')->first();
        //dd($perm);
        $response = $this->withHeaders($this->headers($this->user()))->json('PATCH','api/permission/'.$perm->id,['id' => $perm->id,'name' => 'Test','display_name' => 'Test dispname','description' => 'Opis','groupName' => 'Test']);
        $response->dump();
        //$response->dumpHeaders();
        $response->assertStatus(201);
    }

    public function test_user_can_delete_permissions()
    {
        $perm = Permission::whereName('Test')->get();
        //$perm = $this->withHeaders($this->headers($this->user()))->json('GET','api/permission');
        //$perm->dump();
        //dd($perm->msg);
        $response = $this->withHeaders($this->headers($this->user()))->json('DELETE','api/permission/'.$perm->id);
        //$perm->dumpHeaders();
        $response->assertStatus(201);
    }
}
