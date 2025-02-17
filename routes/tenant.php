<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::group(['middleware' => 'auth'], function ()
{

    /*****************************************************************************************************************/
    // Routes that only platform managers can access
    Route::group(['middleware' => ['role:Super Admin']], function ()
    {
        Route::resource('roles', 'RoleController');
        Route::post('roles/update/all', 'RoleController@updateAll')->name('roles.update.all');
        Route::resource('permissions', 'PermissionController');
        Route::get('userloginfo', [HomeController::class => 'userLogInfo'])->name('userloginfo');
        Route::get('logactivity', [HomeController::class => 'logActivity'])->name('logactivity');

        // Route::get('/batch/{batchId}', function (string $batchId) {
        //     return Bus::findBatch($batchId);
        // });
        Route::get('/batchInProgress', function (string $batchId) {
            $batches = DB::table('job_batches')->where('pending_jobs', '>', 0)->get();
            if (count($batches) > 0) {
                return Bus::findBatch($batches[0]->id);
            }

            return [];
        });

    });

    /*****************************************************************************************************************/

    // Routes that platform managers and administrators can access
    Route::group(['middleware' => ['role:Super Admin|Admin']], function ()
    {
        Route::resource('provider', 'ProviderController');
    });

    /*****************************************************************************************************************/

    // Routes that platform managers and providers can access
    Route::group(['middleware' => ['role:Super Admin|Admin|Provider']], function ()
    {
        Route::resource('bullethq', 'BullethqController');

        Route::get('invoices/index', ['as' => 'invoices.index','uses' => 'MsftInvoicesController@index']);
            Route::get('invoices/downloadinvoice/{invoice_id}', [ 'as' => 'invoices.downloadinvoice', 'uses' => 'MsftInvoicesController@downloadInvoice' ]);

            Route::get('/instances/kascreate', 'InstanceController@kascreate')->name('instances.kascreate');
            Route::resource('/instances', \App\Http\Controllers\Web\InstanceController::class);

            // Route::get('/instances', [\App\Http\Livewire\Instance\ShowInstance::class, '__invoke'])->name('instances.index');


            Route::get('/product/import/{provider_id}', 'ProductController@import')->name('product.import');

            Route::get('/instances/getMasterToken/{provider_id}', 'InstanceController@getMasterToken')->name('instances.getMasterToken');

            // Route::get('/reseller/create', 'ResellerController@create')
            // ->middleware('permission:' . config('app.reseller_create'))->name('reseller.create');

            // Route::post('/reseller', 'ResellerController@store')->middleware('permission:' . config('app.reseller_create'))->name('reseller.store');
            // Route::resource('product', 'ProductController');
            Route::get('/product', [\App\Http\Livewire\Product\ProductTable ::class, '__invoke'])->name('product');
            Route::get('/product/create', [\App\Http\Livewire\Product\ProductAdd ::class, '__invoke'])->name('product.create');


            Route::group(['middleware' => ['check_provider']], function ()
            {
                /*
                Inicio Confirmar nivel de acesso reseller->provider
                */
                Route::get('provider/{provider}/priceList', 'ProviderController@getPriceList')->name('provider.price_lists');
                /*
                Fim Confirmar nivel de acesso reseller->provider
                */
            });

        });

        /*****************************************************************************************************************/

        // Routes that platform managers, providers and resellers can access
        Route::group(['middleware' => ['role:' . config('app.super_admin') . '|' . config('app.admin' ) . '|' . config('app.provider' ) . '|' . config('app.reseller') . '|' . config('app.subreseller')]], function ()
        {
            //Jobs Routes
            Route::get('jobs', 'JobsController@index')->name('jobs');
            Route::get('jobsfailed', 'JobsController@jobsfailed')->name('jobsfailed');
            Route::get('jobs/retry/{id}', 'JobsController@retryJob')->name('jobs.retry');
            Route::get('jobs/pending', 'JobsController@pending')->name('jobs.pending');
            Route::get('jobs/destroy/{id}', 'JobsController@destroy')->name('jobs.destroy');

            // Route::get('/customer/create', 'CustomerController@create')->middleware('permission:' . config('app.customer_create'))->name('customer.create');
            // Route::post('/customer', 'CustomerController@store')->middleware('permission:' . config('app.customer_create'))->name('customer.store');
            // Route::get('/customer', [App\Http\Controllers\Web\CustomerController::class => 'index'])->middleware('permission:' . config('app.customer_index'))->name('customer.index');
            Route::get('/customer', [\App\Http\Livewire\Customer\CustomerTable::class, '__invoke'])->middleware('permission:' . config('app.customer_index'))->name('customer.index');

            Route::get('priceList/{priceList}/prices', 'PriceListController@getPrices')->name('priceList.prices');
            Route::get('priceList/clone/{id}', 'PriceListController@clone')->name('priceList.clone');
            Route::post('priceList/update/{id}', 'PriceListController@update')->name('priceList.update');
            Route::post('pricelist/import', 'PriceListController@import');
            Route::post('pricelist/storePriceList', 'PriceListController@storePriceList')->name('priceList.storePriceList');


            // Route::get('/reseller/{reseller}-{slug}', 'ResellerController@show')->middleware('permission:' . config('app.reseller_show'))->name('reseller.show');
            Route::get('/reseller/{reseller}-{slug}', [\App\Http\Livewire\Reseller\ShowReseller ::class, '__invoke'])->middleware('permission:' . config('app.reseller_show'))->name('reseller.show');
            Route::get('/reseller', [\App\Http\Livewire\Reseller\ResellerTable::class, '__invoke'])->middleware('permission:' . config('app.reseller_index'))->name('reseller.index');

            /*
            Inicio Confirmar nivel de acesso reseller->provider
            */
            Route::get('reseller/{reseller}/priceList', 'ResellerController@getPriceList')->name('reseller.price_lists');
            Route::get('/jobs', 'JobsController@index')->name('jobs');
            Route::get('jobs/retry/{id}', 'JobsController@retryJob')->name('jobs.retry');
            Route::get('jobs/destroy/{id}', 'JobsController@destroy')->name('jobs.destroy');
            /*
            Fim Confirmar nivel de acesso reseller->provider
            */


        });

        /*****************************************************************************************************************/
        /**
        * Roles & Permissions
        */
        Route::group(['namespace' => 'Authorization'], function () {
            Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');
            Route::post('permissions/save', 'RolePermissionsController@update')->name('permissions.save')->middleware('permission:permissions.manage');
            Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
        });

        // Routes that platform managers, providers, resellers and customers can access
        Route::group(['middleware' => ['role:Super Admin|Admin|Provider|Reseller|Sub Reseller|Customer']], function () {
            //User Routes
            Route::get('/settings/{user}', [\App\Http\Livewire\User\GeneralSettings ::class, '__invoke'])->name('settings')->middleware(['universal', InitializeTenancyByDomain::class]);

            Route::get('/user/{user}/security', 'UsersController@security')->name('user.security');
            Route::post('/user/generateToken', 'UsersController@generateToken')->name('user.generateToken');
            Route::resource('/user', 'UsersController');
            Route::get('/user/profile/{user}', 'UsersController@profile')->name('user.profile');
            Route::get('/user/{user}/notifications', 'UsersController@notifications')->name('user.notifications');
            Route::get('/profile/{user}/show-profile', 'UsersController@showprofile')->name('profile.showprofile');
            // Route::get('/profile/{user}/show-profile', 'UsersController@showprofile')->name('profile.show-profile');
            Route::post('/user/updatepassword/{user}', 'UsersController@updatepassword')->name('user.updatepassword');
            Route::put('update/login-details/{user}', 'UsersController@updatelogin')->name('user.update.login-details');
            Route::get('/customer/serviceCostsLineitems/{id}', 'CustomerController@serviceCostsLineitems')->name('customer.serviceCostsLineitems');

            Route::group(['middleware' => ['check_customer']], function ()
            {
                Route::get('/customer/{customer}-{slug}', 'CustomerController@show')->middleware('permission:' . config('app.customer_show'), 'check_customer') ->name('customer.show');

                /*
                Inicio Confirmar nivel de acesso reseller->provider
                */
                Route::get('/customer/{customer}/priceList', 'CustomerController@getPriceList')->name('customer.pricelist');
                /*
                fim Confirmar nivel de acesso reseller->provider
                */

            });

        });

        /*****************************************************************************************************************/

        // Every authenticated user can access routes here
            Route::get('DatabaseNotificationsMarkasRead', function () { auth()->user()->unreadNotifications->markAsRead(); return redirect()->back(); })->name('databasenotifications.markasread');
            //PriceList Routes
            Route::resource('/priceList', 'PriceListController');
            // Route::resource('/price', 'PriceController');
            Route::get('/order/placeOrder', 'OrderController@placeOrder')->name('order.place_order');
            Route::get('/order/placeOrderForVerification', 'OrderController@saveOrderForVerification')->name('order.save_order_for_verification');
            Route::get('/order/verifyOrder', 'OrderController@verifyOrder')->name('order.verify');
            Route::get('/dashboard', [HomeController::class => 'dashboard'])->name('dashboard');
            // Route::resource('/subscription', 'SubscriptionController');
            Route::get('/subscription', [\App\Http\Livewire\Subscription\SubscriptionTable::class, '__invoke'])->middleware('permission:' . config('app.subscription_index'))->name('subscription.index');

            Route::get('/subscription.card', 'SubscriptionController@card')->middleware('permission:' . config('app.subscription_edit'))->name('subscription.card');

            //Novas rotas carrinho//
            Route::post('/cart/customer/add', 'CartController@addCustomer')->name('cart.add_customer');
            Route::post('/cart/customer/change', 'CartController@changeCustomer')->name('cart.change.customer');
            Route::post('/cart/tenant/change', 'CartController@changeTenant')->name('cart.change.tenant');
            Route::get('/cart/tenant', 'CartController@continueCheckout')->name('cart.tenant');
            Route::get('/cart/review', 'CartController@continueCheckout')->name('cart.review');
            // Route::post('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
            Route::post('/cart/customer', 'CartController@storeCustomerAndBuy')->middleware('permission:' . config('app.customer_create'))->name('cart.customer.store');

            Route::get('/cart/checkout', [\App\Http\Livewire\Shop\Checkout ::class, '__invoke'])->name('cart.checkout');

            //Novas rotas carrinho//
            Route::get('cart/pending', 'CartController@getPending')->name('cart.pending');
            Route::get('cart/item/changeBillingCycle', 'CartController@changeBillingCycle')->name('cart.main_user');
            Route::get('/cart/customer/mainUser', 'CartController@getMainUser')->name('cart.main_user');
            Route::post('/cart/product/add', 'CartController@addProductToCart')->name('cart.add_to_cart');
            Route::get('/cart/item/{id}/quantity/{quantity}', 'CartController@changeProductQuantity');
            Route::get('/cart/add/product/{product}', 'CartController@addProduct')->name('cart.add_product');
            Route::get('/cart/remove/item/{item}', 'CartController@removeItem')->name('cart.remove_product');
            Route::get('/cart/clear', 'CartController@destroy')->name('cart.clear');
            Route::post('/cart/pending/checkout', 'CartController@pendingCheckout')->name('cart.pending_checkout');
            Route::get('/cart/checkDomainAvailability', 'CartController@checkDomainAvailability')->name('cart.check_domain_availability');
            Route::post('/cart/addMCAUser', 'CartController@addMCAUser')->name('cart.add_mca_user');
            Route::resource('/cart', 'CartController');
            Route::get('/store/categories/{vendor}', 'StoreController@categories')->name('store.categories');
            Route::get('/store/searchstore/{vendor}/{category}', 'StoreController@searchstore')->name('store.searchstore');
            Route::resource('/store', 'StoreController');

            Route::get('products/{id}', 'ProductController@show');

            // Route::resource('/order', 'OrderController');
            Route::get('/order', [\App\Http\Livewire\Order\OrderTable::class, '__invoke'])->name('order.index');


            //Analytics Routes
            // Route::get('/analytics',                                    ['uses' => 'AnalyticController@index','as'                  => 'analytics.list']);



            Route::get('/analytics/azurepricelist/{instance}',          ['uses' => 'AnalyticController@azurepricelist','as'         => 'analytics.azurepricelist']);
            Route::get('/analytics/details/{customer}/{subscription}',  ['uses' => 'AnalyticController@getAzuredetails','as'        => 'analytics.details']);
            Route::get('/analytics/update/{customer}/{subscription}',   ['uses' => 'AnalyticController@updateAZURE','as'            => 'analytics.update']);
            Route::get('/analytics/export/{customer}/{subscription}',   ['uses' => 'AnalyticController@export','as'                 => 'analytics.export']);
            Route::get('/analytics/updatepricesinreports',              ['uses' => 'AnalyticController@updatepricesinreports','as'  => 'analytics.updatepricesinreports']);
            Route::get('/analytics/licenses',                           ['uses' => 'AnalyticController@licenses','as'               => 'analytics.licenses']);
            Route::get('/customer/costs',                               ['uses' => 'CustomerController@CustomerServiceCosts','as'   => 'customer.costs']);
            Route::get('/analytics/show/',                              ['uses' => 'AnalyticController@show','as'                   => 'analytics.show']);
            Route::post('/analytics/edit/',                             ['uses' => 'AnalyticController@edit','as'                   => 'analytics.edit']);

            // Route::get('/analytics/reports/{subscription}', ['uses' => 'AnalyticController@azurereport','as' => 'analytics.reports']);
            // route::get('/analytics/reports/{subscription}', ['uses' =>  '\App\Http\Controllers\Web\App\Livewire\Azure\AzureReport']);

            //Analytics news
            Route::get('news', [ 'as' => 'news.list', 'uses' => 'AdminController@news' ]);
            Route::post('news/create', [ 'as' => 'news.create', 'uses' => 'AdminController@createNews' ]);
            Route::get('news/create', [ 'as' => 'news.create', 'uses' => 'AdminController@createNews' ]);
            Route::get('news/{news}/edit', [ 'as' => 'news.edit', 'uses' => 'AdminController@editNews' ]);
            Route::get('news/{news}/view', [ 'as' => 'news.view', 'uses' => 'AdminController@viewNews' ]);
            Route::post('news/{news}/delete', [ 'as' => 'news.delete', 'uses' => 'AdminController@deleteNews' ]);
            Route::post('news/{news}/update', [ 'as' => 'news.update', 'uses' => 'AdminController@updateNews' ]);
        // End of every authenticated user can access routes here
        });


        Auth::routes(['register' => true]);
        Route::redirect('/', '/home', 301);
        Route::get('/home', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
        Route::impersonate();
        Auth::routes();

        Route::get('/mailable', function () {
            $invoice = App\Subscription::first();

            return new App\Mail\SubscriptionAlertRenew($invoice);
        });

});
