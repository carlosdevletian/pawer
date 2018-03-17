<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewSizesTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function signed_in_user_can_view_a_list_of_all_sizes()
    {
        [$sizeA, $sizeB, $sizeC, $sizeD] = create('Size', [], 4);

        $response = $this->signIn()->get(route('admin.sizes.index'));

        $response->assertViewIs('admin.sizes.index');
        $response->data('sizes')->assertEquals([
            $sizeA,
            $sizeB,
            $sizeC,
            $sizeD
        ]);
    }

    /** @test*/
    public function guests_cannot_view_a_list_of_all_sizes()
    {
        [$sizeA, $sizeB, $sizeC, $sizeD] = create('Size', [], 4);

        $this->get(route('admin.sizes.index'))->assertStatus(302);
    }
}
