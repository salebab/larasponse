<?php namespace Sorskod\Larasponse;

use Illuminate\Support\ServiceProvider;
use Sorskod\Larasponse\Providers\Fractal;

class LarasponseServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('League\Fractal\Serializer\SerializerAbstract', 'League\Fractal\Serializer\ArraySerializer');

        $this->app->bind('Sorskod\Larasponse\Larasponse', function($app)
        {
            return new Fractal(
                $app['League\Fractal\Serializer\SerializerAbstract'],
                $app['Illuminate\Http\Request']
            );
        });
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
