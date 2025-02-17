<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers\Web';
	protected $webNamespace = 'App\Http\Controllers\Web';
	protected $apiNamespace = 'App\Http\Controllers\Api';

	/**
	 * The path to the "home" route for your application.
	 *
	 * @var string
	 */
	public const HOME = '/home';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
        // $this->configureRateLimiting();

        $this->routes(function () {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    });
		// parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->mapApiRoutes();
		$this->mapWebRoutes();
	}

    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }

	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	// protected function mapWebRoutes()
	// {
	// 	Route::group([
	// 		'namespace' => $this->webNamespace,
	// 		'middleware' => 'web',
	// 	], function ($router) {
	// 		require base_path('routes/web.php');
	// 	});
	// }

	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	// protected function mapApiRoutes()
	// {
	// 	Route::group([
    //         'middleware' => 'api',
    //         'namespace' => $this->apiNamespace,
    //         'prefix' => 'api',
    //     ], function () {
    //         require base_path('routes/api.php');
    //     });
	// }
}
