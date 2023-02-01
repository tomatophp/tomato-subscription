<?php

namespace TomatoPHP\TomatoSubscription;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\TomatoPHP\Services\Menu\TomatoMenuRegister;
use TomatoPHP\TomatoSubscription\Console\GenerateFeatures;
use TomatoPHP\TomatoSubscription\Menus\PlanMenu;


class TomatoSubscriptionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\TomatoSubscription\Console\TomatoSubscriptionInstall::class,
            GenerateFeatures::class
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/tomato-subscription.php', 'tomato-subscription');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/tomato-subscription.php' => config_path('tomato-subscription.php'),
        ], 'config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tomato-subscription');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/tomato-subscription'),
        ], 'views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tomato-subscription');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => resource_path('lang/vendor/tomato-subscription'),
        ], 'lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        //Register Menu
        TomatoMenuRegister::registerMenu(PlanMenu::class);

    }

    public function boot(): void
    {
        //you boot methods here
    }
}
