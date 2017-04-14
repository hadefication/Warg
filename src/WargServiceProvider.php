<?php

namespace Hadefication\Warg;

use Illuminate\Support\ServiceProvider;

class WargServiceProvider extends ServiceProvider
{

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('warg', function () {
            return $this->app->make('Hadefication\Warg\Warg');
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
