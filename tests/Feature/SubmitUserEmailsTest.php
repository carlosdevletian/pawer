<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmitUserEmailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function guests_can_submit_their_email()
    {
        $this->assertDatabaseMissing('email_subscriptions', [
            'email' => 'john@example.com'
        ]);

        $this->withoutExceptionHandling()->post('email-subscriptions', [
            'email' => 'john@example.com'
        ]);


        $this->assertDatabaseHas('email_subscriptions', [
            'email' => 'john@example.com'
        ]);
    }

    /** @test*/
    public function email_is_required()
    {
        $this->assertDatabaseMissing('email_subscriptions', [
            'email' => ''
        ]);

        $response = $this->post('email-subscriptions', [
            'email' => ''
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('email_subscriptions', [
            'email' => ''
        ]);
    }

    /** @test*/
    public function email_must_be_a_valid_email()
    {
        $this->assertDatabaseMissing('email_subscriptions', [
            'email' => 'not-an-email'
        ]);

        $response = $this->post('email-subscriptions', [
            'email' => 'not-an-email'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('email_subscriptions', [
            'email' => 'not-an-email'
        ]);
    }
}
