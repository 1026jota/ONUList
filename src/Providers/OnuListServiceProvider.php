<?php
namespace Jota\OnuList\Providers;

use Illuminate\Support\ServiceProvider;
use Jota\OnuList\Classes\OnuList;

class OnuListServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('OnuList', function () {
            return new OnuList();
        });
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->publishes([
            __DIR__ . '/../../config/onulist.php' => config_path('onulist.php'),
        ]);
    }
}
