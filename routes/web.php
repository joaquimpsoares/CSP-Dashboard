<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notification;
use App\Notifications\FailedJob;

//Marco verifica aqui esta linha... para a importação dos productos!


Route::get('/jobs', 'JobsController@index')->name('jobs');
Route::get('jobs/retry/{id}', 'JobsController@retryJob')->name('jobs.retry');
Route::get('jobs/pending', 'JobsController@pending')->name('jobs.pending');
Route::get('jobs/destroy/{id}', 'JobsController@destroy')->name('jobs.destroy');

Route::post('provider/register', 'ProviderController@store')->name('provider.register');

Route::resource('/user', 'UsersController');


/**********************************************************************************
Início Rotas que necessitam ser verificadas e inseridas em seus devídos midlewares groups

**********************************************************************************/
Route::get('/test/{domain}', 'CartController@checkDomain');
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
		Route::get('/product/import', 'ProductController@import')->name('product.import');

		Route::resource('instances', 'InstanceController');

	});

	/*****************************************************************************************************************/

	// Routes that platform managers and administrators can access
	Route::group(['middleware' => ['role:Super Admin|Admin']], function () {

		Route::resource('provider', 'ProviderController');
		Route::get('priceList/{priceList}/prices', 'PriceListController@getPrices')->name('priceList.prices');

	});

	/*****************************************************************************************************************/

	// Routes that platform managers and providers can access
	Route::group(['middleware' => ['role:Super Admin|Admin|Provider']], function () {

		Route::group(['middleware' => ['check_provider']], function () {

			Route::get('/reseller', 'ResellerController@index')
			->middleware('permission:' . config('app.reseller_create'))->name('reseller.create');

			/*Route::get('/priceList/provider/{provider}', 'PriceListController@getProviderPriceList')
			->middleware('permission:' . config('app.price_list_show'))->name('priceLists.provider_price_list');*/

			Route::resource('/priceList', 'PriceListController');

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

		Route::get('/customer', 'CustomerController@index')
		->middleware('permission:' . config('app.customer_index'))->name('customer.index');


		Route::group(['middleware' => ['check_reseller']], function () {

			Route::get('/reseller/{reseller}-{slug}', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_show'))->name('reseller.show');

			Route::get('reseller/{reseller}-{slug}/edit', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_edit'))->name('reseller.edit');

			Route::get('reseller/{reseller}-{slug}/customers', 'ResellerController@getCustomersFromReseller')
			->middleware('permission:' . config('app.customer_index'))->name('reseller.customers');


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

			Route::get('customer/{customer}-{slug}/edit', 'CustomerController@show')
			->middleware('permission:' . config('app.customer_edit'))
			->name('customer.edit');

			/*
			Inicio Confirmar nivel de acesso reseller->provider
			*/
			Route::get('/customer/{customer}/mainUser', 'CustomerController@getMainUser')->name('customer.main_user');
			Route::get('/customer/{customer}/priceList', 'CustomerController@getPriceList')->name('customer.pricelist');

			/*
			fim Confirmar nivel de acesso reseller->provider
			*/
		});

	});

	/*****************************************************************************************************************/

	// Every authenticated user can access routes here
	
	Route::get('/order/placeOrder', 'OrderController@placeOrder')->name('store.place_order');
	Route::get('/order/product/{product}/quantity/{quantity}', 'OrderController@changeProductQuantity');
	Route::post('/order/product/add', 'OrderController@addProductToCart')->name('order.add_to_cart');
	Route::get('/order/shoppingcart', 'OrderController@getCart')->name('order.shoppingcart');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/cart/add/product/{product}', 'CartController@addProduct')->name('cart.add_product');
	Route::get('/cart/remove/product/{product}', 'CartController@removeProduct')->name('cart.remove_product');
	Route::get('/cart/clear', 'CartController@destroy')->name('cart.clear');
	Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
	Route::get('/cart/customer/{customer}/add', 'CartController@addCustomer')->name('cart.add_customer');
	Route::get('/cart/checkDomainAvailability/{domain}', 'CartController@checkDomainAvailability')->name('cart.check_domain_availability');
	Route::post('/cart/addMCAUser', 'CartController@addMCAUser')->name('cart.add_mca_user');


	Route::resource('/cart', 'CartController');
	Route::resource('/store', 'StoreController');
	Route::get('products/test', 'ProductController@index2');
	Route::resource('product', 'ProductController');

	// End of every authenticated user can access routes here
});

//Auth::routes();

// Auth::routes(['register' => false]);
Route::impersonate();

Route::get('/', function() {
	return view('home');
})->name('home');

Auth::routes();



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
