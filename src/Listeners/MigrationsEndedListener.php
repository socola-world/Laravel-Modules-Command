<?php

namespace SocolaDaiCa\LaravelModulesCommand\Listeners;

use Illuminate\Support\Facades\Artisan;

class MigrationsEndedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Artisan::call('cms:ide-helper');
    }
}
