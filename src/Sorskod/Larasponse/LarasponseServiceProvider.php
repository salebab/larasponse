<?php namespace Sorskod\Larasponse;

use Illuminate\Support\ServiceProvider;

class LarasponseServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('League\Fractal\Serializer\SerializerAbstract', 'League\Fractal\Serializer\ArraySerializer');
        $this->app->bind('Sorskod\Larasponse\Larasponse', 'Sorskod\Larasponse\Providers\Fractal');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('larasponse');
    }

}
