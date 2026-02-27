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
	// Laravel 12: avoid a global controller namespace; use explicit namespaces per route group.
	protected $webNamespace = 'App\Http\Controllers\Web';
	protected $apiNamespace = 'App\Http\Controllers\Api';

	/**
	 * The path to the "home" route for your application.
	 *
	 * @var string
	 */
	public const HOME = '/dashboard';

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
        Route::middleware('web')
            ->namespace($this->webNamespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->apiNamespace)
            ->group(base_path('routes/api.php'));
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
