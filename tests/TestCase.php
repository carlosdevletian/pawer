<?php

namespace Tests;

use PHPUnit\Framework\Assert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        Storage::fake('s3');

        TestResponse::macro('data', function($key) {
            return $this->original->getData()[$key];
        });

        Collection::macro('assertEquals', function($items) {
            Assert::assertEquals(count($this), count($items));

            $this->zip($items)->each(function ($pair) {
                list($a, $b) = $pair;
                Assert::assertTrue($a->is($b));
            });
        });
    }

    protected function signIn($user = null)
    {
        $user = $user?: create('User');

        $this->actingAs($user);

        return $this;
    }

    protected function signOut()
    {
        if(auth()->check()) auth()->logout();

        return $this;
    }

    protected function fakeEvents($eventsToFake = [])
    {
        $modelDispatcher = Model::getEventDispatcher();
        Event::fake($eventsToFake);
        Model::setEventDispatcher($modelDispatcher);

        return $this;
    }
}
