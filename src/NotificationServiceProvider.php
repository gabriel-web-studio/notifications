<?php

namespace GabrielWebStudio\Notifications;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            \GabrielWebStudio\Notifications\Console\InstallCommand::class
        ]);
    }
}
