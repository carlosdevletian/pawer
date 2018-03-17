<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Size;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSizeTest extends TestCase
{
    use RefreshDatabase;

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'large'
        ], $overrides);
    }

    /** @test*/
    public function logged_in_users_can_see_the_page_to_create_sizes()
    {
        $this->signIn()
            ->get(route('admin.sizes.create'))
            ->assertSuccessful()
            ->assertViewIs('admin.sizes.create');
    }

    /** @test*/
    public function guests_cannot_see_the_page_to_create_sizes()
    {
        $this->get(route('admin.sizes.create'))
            ->assertStatus(302);
    }

    /** @test*/
    public function logged_in_users_can_create_a_size()
    {
        $this->signIn()->post(route('admin.sizes.store'), [
            'name' => 'small',
        ]);

        tap(Size::first(), function($size) {
            $this->assertEquals('small', $size->name);
        });
    }

    /** @test*/
    public function guests_cannot_create_a_size()
    {
        $this->post(route('admin.sizes.store'), $this->validParams())->assertStatus(302);

        $this->assertCount(0, Size::get());
    }

    /** @test*/
    public function name_is_required()
    {
        $this->signIn()->post(route('admin.sizes.store'), $this->validParams([
            'name' => '',
        ]))->assertSessionHasErrors('name');
    }
}
