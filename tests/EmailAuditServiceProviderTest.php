<?php

namespace  Roland\LaravelEmailAuditing\Tests;

use Illuminate\Support\Facades\Event;
use Roland\LaravelEmailAuditing\EmailAuditingServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use Roland\LaravelEmailAuditing\Listeners\EmailHasBeenSentListener;
use Tests\TestCase;

class EmailAuditServiceProviderTest extends TestCase
{


    /** @test */
    public function it_registers_email_audit_listener()
    {
        // Arrange
        $provider = new EmailAuditingServiceProvider($this->app);

        // Act
        $provider->boot();

        // Assert
        Event::fake();
        Event::assertListening(MessageSent::class, EmailHasBeenSentListener::class);
    }
}
