<?php

namespace JiSight\Message;

use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $this->app->make(Message::class);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
//        $this->app->singleton(Message::class, function () {
//            return $this->app->make(Message::class);
//        });

    }
}
