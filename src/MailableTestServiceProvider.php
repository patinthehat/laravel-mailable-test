<?php

namespace Spatie\MailableTest;

use Illuminate\Support\ServiceProvider;

class MailableTestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/laravel-mailable-test.php' => config_path('laravel-mailable-test.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind(MailableFactory::class, function() {
            $argumentValueProviderClass = config('laravel-mailable-test.argument_value_provider_class');

            $argumentValueProvider = app($argumentValueProviderClass);

            return new MailableFactory($argumentValueProvider);
        });

        $this->app->bind(ArgumentValueProvider::class, function() {
           $faker = \Faker\Factory::create();

           return new ArgumentValueProvider($faker);
        });

        $this->commands([
            SendTestMail::class,
        ]);
    }

    public function provides()
    {
        return ['command.mail.send.test'];
    }
}
