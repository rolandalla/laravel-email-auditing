<?php

namespace Roland\LaravelEmailAuditing;

use Roland\LaravelEmailAuditing\Listeners\EmailHasBeenSentListener;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EmailAuditingServiceProvider extends ServiceProvider
{
    use Dispatchable, SerializesModels;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/2024_02_01_205101_auditing_create_email_auditing_table.php' =>
                $this->app->databasePath(
                    '/migrations/2024_02_01_205101_auditing_create_email_auditing_table.php'
                )
        ], 'email-auditing-migrations');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Event::listen(MessageSent::class, EmailHasBeenSentListener::class);
    }

    public function register()
    {
        //
    }



}
