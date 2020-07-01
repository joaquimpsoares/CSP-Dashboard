<?php

use App\Order;
use App\Customer;
use App\Instance;
use Carbon\Carbon;
use App\Subscription;
use App\MicrosoftTenantInfo;
use App\Jobs\PlaceOrderMicrosoft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;

//Marco verifica aqui esta linha... para a importação dos productos!

// Route::resource('/analytics', 'AnalyticController');

Route::get('/analytics', [
	'uses' => 'AnalyticController@index',
	'as' => 'analytics.list'
]);

Route::get('/analytics/update', [
	'uses' => 'AnalyticController@updateAZURE',
	'as' => 'analytics.update'
]);

Route::get('/customer/costs', [
	'uses' => 'CustomerController@CustomerServiceCosts',
	'as' => 'customer.costs'
]);


Route::post('/analytics/edit/', [
	'uses' => 'AnalyticController@edit',
	'as' => 'analytics.edit'
]);

Route::get('/analytics/show/', [
	'uses' => 'AnalyticController@show',
	'as' => 'analytics.show'
]);

Route::resource('/priceList', 'PriceListController');



Route::get('/jobs', 'JobsController@index')->name('jobs');
Route::get('jobs/retry/{id}', 'JobsController@retryJob')->name('jobs.retry');
Route::get('jobs/pending', 'JobsController@pending')->name('jobs.pending');
Route::get('jobs/destroy/{id}', 'JobsController@destroy')->name('jobs.destroy');

Route::post('provider/register', 'ProviderController@store')->name('provider.register');

Route::resource('/user', 'UsersController');

Route::get('/user/profile/{user}', 'UsersController@profile')->name('user.profile');


Route::post('registerInvitation', 'UsersController@registerInvitation')->name('registerInvitation');


Route::get('invite', 'InviteController@invite')->name('invite');
Route::post('invite', 'InviteController@process')->name('process');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'InviteController@accept')->name('accept');



/**********************************************************************************
Início Rotas que necessitam ser verificadas e inseridas em seus devídos midlewares groups

**********************************************************************************/
Route::get('/test', function() {
	$customers = App\Customer::all();
	dump($customers);
});
/**********************************************************************************
Fim Rotas que necessitam ser verificadas e inseridas em seus devídos midlewares groups

**********************************************************************************/


Route::group(['middleware' => 'auth'], function () {
	
	
	/*****************************************************************************************************************/
	
	// Routes that only platform managers can access
	Route::group(['middleware' => ['role:Super Admin']], function () {
		
		Route::resource('roles', 'RoleController');
		Route::post('roles/update/all', 'RoleController@updateAll')->name('roles.update.all');
		Route::resource('permissions', 'PermissionController');
		Route::get('/product/import/{provider_id}', 'ProductController@import')->name('product.import');
		
		Route::resource('/instances', 'InstanceController');
		Route::get('/instances/getMasterToken/{provider_id}', 'InstanceController@getMasterToken')->name('instances.getMasterToken');
		
	});
	
	/*****************************************************************************************************************/
	
	// Routes that platform managers and administrators can access
	Route::group(['middleware' => ['role:Super Admin|Admin']], function () {
		
		Route::resource('provider', 'ProviderController');
		

	});
	
	/*****************************************************************************************************************/
	
	// Routes that platform managers and providers can access
	Route::group(['middleware' => ['role:Super Admin|Admin|Provider']], function () {
		
			Route::get('/reseller/create', 'ResellerController@create')
				->middleware('permission:' . config('app.reseller_create'))->name('reseller.create');

			Route::post('/reseller', 'ResellerController@store')
				->middleware('permission:' . config('app.reseller_create'))->name('reseller.store');

			Route::group(['middleware' => ['check_provider']], function () {
			
		

			
			/*Route::get('/priceList/provider/{provider}', 'PriceListController@getProviderPriceList')
			->middleware('permission:' . config('app.price_list_show'))->name('priceLists.provider_price_list');*/
			

			
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
	Route::group(['middleware' => ['role:' . config('app.super_admin') . '|' . config('app.admin' ) . '|' . config('app.provider' ) . '|' . config('app.reseller') . '|' . config('app.subreseller')]], function () {
		
		Route::get('/reseller', 'ResellerController@index')
		->middleware('permission:' . config('app.reseller_index'))->name('reseller.index');

		Route::get('/customer/create', 'CustomerController@create')
			->middleware('permission:' . config('app.customer_create'))->name('customer.create');

		Route::post('/customer', 'CustomerController@store')
			->middleware('permission:' . config('app.customer_create'))->name('customer.store');
		
		
		Route::get('/customer', 'CustomerController@index')
		->middleware('permission:' . config('app.customer_index'))->name('customer.index');

		Route::get('priceList/{priceList}/prices', 'PriceListController@getPrices')->name('priceList.prices');
		Route::get('priceList/clone/{id}', 'PriceListController@clone')->name('priceList.clone');
		Route::post('priceList/update/{id}', 'PriceListController@update')->name('priceList.update');
		
		Route::post('pricelist/import', 'PriceListController@import');
		
		
		Route::group(['middleware' => ['check_reseller']], function () {
			

			// Route::resource('reseller', 'ResellerController');
			

			Route::get('/reseller/{reseller}-{slug}', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_show'))->name('reseller.show');
			
			Route::patch('/reseller/update/{reseller}', 'ResellerController@update')
			->name('reseller.update');
			
			Route::get('reseller/{reseller}-{slug}/edit', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_edit'))->name('reseller.edit');
			
			Route::get('reseller/{reseller}-{slug}/customers', 'ResellerController@getCustomersFromReseller')
			->middleware('permission:' . config('app.customer_index'))->name('reseller.customers');
			
			// Route::resource('/priceList', 'PriceListController');
			
			
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
		
		Route::group(['middleware' => ['check_customer']], function () {
			//Route::get('/priceList/customer/{customer}', 'PriceListController@getCustomerPriceList')->name('priceLists.customer_price_list');
		});
		
	});
	
	/*****************************************************************************************************************/
	
	// Routes that platform managers, providers, resellers and customers can access
	Route::group(['middleware' => ['role:Super Admin|Admin|Provider|Reseller|Sub Reseller|Customer']], function () {
		
		Route::group(['middleware' => ['check_customer']], function () {
			
			
			Route::get('/customer/{customer}-{slug}', 'CustomerController@show')
			->middleware('permission:' . config('app.customer_show'), 'check_customer')
			->name('customer.show');
			
			Route::post('customer/update/{customer}', 'CustomerController@update')
			->middleware('permission:' . config('app.customer_update'))
			->name('customer.update');
			
			
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
	Route::get('/order/placeOrder', 'OrderController@placeOrder')->name('order.place_order');

	
	
	Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
	
	//Novas rotas carrinho//
	Route::post('/cart/customer/add', 'CartController@addCustomer')->name('cart.add_customer');
	Route::post('/cart/customer/change', 'CartController@changeCustomer')->name('cart.change.customer');
	Route::post('/cart/tenant/change', 'CartController@changeTenant')->name('cart.change.tenant');
	Route::get('/cart/tenant', 'CartController@continueCheckout')->name('cart.tenant');
	Route::get('/cart/review', 'CartController@continueCheckout')->name('cart.review');
	Route::post('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
	Route::post('/cart/customer', 'CartController@storeCustomerAndBuy')
			->middleware('permission:' . config('app.customer_create'))->name('cart.customer.store');
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
	Route::resource('/subscription', 'SubscriptionController');
			Route::get('/subscription.card', 'SubscriptionController@card')
			->middleware('permission:' . config('app.subscription_edit'))
			->name('subscription.card');
	
	Route::resource('/cart', 'CartController');
	Route::resource('/store', 'StoreController');
	Route::get('products/test', 'ProductController@index2');
	Route::resource('product', 'ProductController');
	Route::resource('/order', 'OrderController');
	
	
	// End of every authenticated user can access routes here
	});


	Auth::routes(['register' => true]);

	Route::impersonate();

	Route::get('/', 'HomeController@index')->name('home');

	Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');
