<?php
namespace Padosoft\ComposerSecurityCheck;
use Illuminate\Support\ServiceProvider;
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
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['command.composer-security-check'] = $this->app->share(
            function ($app) {
                return new ComposerSecurityCheckCommand();
            }
        );
        $this->commands('command.composer-security-check');
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.composer-security-check'];
    }
}