<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEmailSubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function signed_in_users_can_view_a_list_of_all_email_subscriptions()
    {
        $subscriptionA = create('EmailSubscription', ['email' => 'john@example.com']);
        $subscriptionB = create('EmailSubscription', ['email' => 'jane@example.com']);
        $subscriptionC = create('EmailSubscription', ['email' => 'bill@example.com']);

        $response = $this->signIn()->get('/email-subscriptions');

        $response->data('subscriptions')->assertEquals([
            $subscriptionA,
            $subscriptionB,
            $subscriptionC,
        ]);
    }

    /** @test*/
    public function guests_cannot_view_a_list_of_all_email_subscriptions()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $emailA = create('EmailSubscription', ['email' => 'john@example.com']);
        $emailB = create('EmailSubscription', ['email' => 'jane@example.com']);
        $emailC = create('EmailSubscription', ['email' => 'bill@example.com']);

        $this->withoutExceptionHandling()->get('/email-subscriptions');
    }
}
