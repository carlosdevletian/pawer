<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewUserIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function signed_in_users_can_view_a_list_of_all_users()
    {
        [$userA, $userB, $userC] = create('User', [], 3);

        $response = $this->signIn($userA)->get(route('admin.users.index'));

        $response->assertViewIs('admin.users.index');
        $response->data('users')->assertEquals([
            $userA,
            $userB,
            $userC,
        ]);
    }

    /** @test*/
    public function guests_cannot_view_a_list_of_all_users()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->withoutExceptionHandling()->get(route('admin.users.index'));
    }
}
