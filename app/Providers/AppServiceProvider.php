<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Event;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot(){
        Event::listen('store.created', 'App\Events\EmailStoreCreated@handle');
    }

    public function register(){}

}
