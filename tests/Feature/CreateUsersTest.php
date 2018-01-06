<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUsersTest extends TestCase
{
    use RefreshDatabase;

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Bill Doe',
            'email' => 'bill@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password'
        ], $overrides);
    }

    /** @test*/
    public function signed_in_users_can_create_user_accounts()
    {
        $this->signIn()->post(route('admin.users.store'), [
            'name' => 'Bill Doe',
            'email' => 'bill@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password'
        ]);

        tap(User::whereEmail('bill@example.com')->firstOrFail(), function($bill) {
            $this->assertEquals('Bill Doe', $bill->name);
            $this->assertTrue(Hash::check('secret-password', $bill->password));
        });
    }

    /** @test*/
    public function guests_cannot_create_user_accounts()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->withoutExceptionHandling()->post(route('admin.users.store'), [
            'name' => 'Bill Doe',
            'email' => 'bill@example.com',
            'password' => 'secret-password'
        ]);
    }

    /** @test*/
    public function signed_in_users_can_see_the_form_to_create_users()
    {
        $response = $this->signIn()->get(route('admin.users.create'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.users.create');
    }

    /** @test*/
    public function guest_cannot_see_the_form_to_create_users()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->withoutExceptionHandling()->get(route('admin.users.create'));
    }

    /** @test*/
    public function name_is_required()
    {
        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'name' => '',
        ]));

        $response->assertSessionHasErrors('name');
    }

    /** @test*/
    public function email_is_required()
    {
        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'email' => '',
        ]));

        $response->assertSessionHasErrors('email');
    }

    /** @test*/
    public function email_must_be_valid_email()
    {
        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'email' => 'not-an-email',
        ]));

        $response->assertSessionHasErrors('email');
    }

    /** @test*/
    public function email_must_be_unique_in_users_table()
    {
        create('User', ['email' => 'some-email@example.com']);

        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'email' => 'some-email@example.com',
        ]));

        $response->assertSessionHasErrors('email');
    }

    /** @test*/
    public function password_is_required()
    {
        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'password' => '',
        ]));

        $response->assertSessionHasErrors('password');
    }

    /** @test*/
    public function password_must_be_at_least_6_characters_long()
    {
        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'password' => 'admin',
        ]));

        $response->assertSessionHasErrors('password');
    }

    /** @test*/
    public function password_must_be_confirmed()
    {
        $response = $this->signIn()->post(route('admin.users.store'), $this->validParams([
            'password_confirmation' => '',
        ]));

        $response->assertSessionHasErrors('password');
    }
}
