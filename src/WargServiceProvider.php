<?php

namespace Hadefication\Warg;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Hadefication\Warg\WargBag;

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
        $this->publishes([
            __DIR__ . '/config/warg.php' => config_path('warg.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/config/warg.php', 'warg'
        );

        View::composer('*', function ($view) {
            $wargSession = session('warg');

            if (is_null($wargSession)) {
                $wargSession = new WargBag(null, null);
            }

            $view->with('wargSession', $wargSession);
        });

        
    }
}
