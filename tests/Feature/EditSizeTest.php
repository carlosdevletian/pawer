<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditSizeTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function signed_in_user_can_see_the_form_update_a_size()
    {
        $size = create('Size', ['name' => 'large']);

        $response = $this->signIn()->get(route('admin.sizes.edit', $size))
            ->assertSuccessful()
            ->assertViewIs('admin.sizes.edit');

        $this->assertTrue($response->data('size')->is($size));
    }

    /** @test*/
    public function guests_cannot_see_the_form_update_a_size()
    {
        $size = create('Size', ['name' => 'large']);

        $response = $this->get(route('admin.sizes.edit', $size))
            ->assertStatus(302);
    }

    /** @test*/
    public function a_signed_in_user_can_update_a_size()
    {
        $size = create('Size', ['name' => 'large']);

        $response = $this->signIn()->patch(route('admin.sizes.update', $size), ['name' => 'small']);

        $this->assertEquals('small', $size->fresh()->name);
    }

    /** @test*/
    public function a_guest_cannot_update_a_size()
    {
        $size = create('Size', ['name' => 'large']);

        $response = $this->patch(route('admin.sizes.update', $size), ['name' => 'small']);

        $this->assertEquals('large', $size->fresh()->name);
        $response->assertStatus(302);
    }

    /** @test*/
    public function name_is_required()
    {
        $size = create('Size', ['name' => 'large']);

        $response = $this->signIn()->patch(route('admin.sizes.update', $size), ['name' => '']);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('large', $size->fresh()->name);
    }
}
