<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteEmailSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function signed_in_users_can_delete_email_subscriptions()
    {
        $subscription = create('EmailSubscription', ['email' => 'john@example.com']);

        $this->assertDatabaseHas('email_subscriptions', [
            'email' => 'john@example.com'
        ]);

        $this->signIn()->delete(route('email-subscriptions.destroy', $subscription));

        $this->assertDatabaseMissing('email_subscriptions', [
            'email' => 'john@example.com'
        ]);
    }

    /** @test*/
    public function guests_cannot_delete_email_subscriptions()
    {
        $subscription = create('EmailSubscription', ['email' => 'john@example.com']);

        $this->assertDatabaseHas('email_subscriptions', [
            'email' => 'john@example.com'
        ]);

        $this->delete(route('email-subscriptions.destroy', $subscription));

        $this->assertDatabaseHas('email_subscriptions', [
            'email' => 'john@example.com'
        ]);
    }
}
