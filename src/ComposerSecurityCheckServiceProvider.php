<?php
namespace Padosoft\Composer;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
class ComposerSecurityCheckServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/composer-security-check.php' => config_path('composer-security-check.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/views', 'composer-security-check');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/padosoft/composer-security-check'),
        ]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['command.composer-security:check'] = $this->app->share(
            function ($app) {
                return new ComposerSecurityCheck(new client);
            }
        );
        $this->commands('command.composer-security:check');

    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.composer-security:check'];
    }
}