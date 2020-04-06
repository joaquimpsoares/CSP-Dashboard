<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Marco verifica aqui esta linha... para a importação dos productos!

Route::get('/products/import', 'ProductController@import')->name('products.import');
Route::get('/jobs', 'JobsController@index')->name('jobs');


Auth::routes(['register' => false]);
Route::impersonate();

Route::get('/', function() {
	return view('home');
})->name('home');


Route::group(['middleware' => 'auth'], function () {

	// Every authenticated user can access routes here

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/cart/add/product/{product}', 'CartController@addProduct')->name('cart.add_product');
	Route::get('/cart/remove/product/{product}', 'CartController@removeProduct')->name('cart.remove_product');
    Route::get('/cart/clear', 'CartController@destroy')->name('cart.clear');


	Route::resource('/cart', 'CartController');
	Route::resource('products', 'ProductController');

	// End of every authenticated user can access routes here

	/*****************************************************************************************************************/

	// Routes that only platform managers can access
	Route::group(['middleware' => ['role:Super Admin']], function () {

        Route::resource('roles', 'RoleController');
		Route::post('roles/update/all', 'RoleController@updateAll')->name('roles.update.all');
        Route::resource('permissions', 'PermissionController');




		Route::resource('instances', 'InstanceController');

	});

	/*****************************************************************************************************************/

	// Routes that platform managers and administrators can access
	Route::group(['middleware' => ['role:Super Admin|Admin']], function () {

		Route::resource('providers', 'ProviderController');

	});

	/*****************************************************************************************************************/

	// Routes that platform managers and providers can access
	Route::group(['middleware' => ['role:Super Admin|Admin|Provider']], function () {

		Route::group(['middleware' => ['check_provider']], function () {

			Route::get('/resellers', 'ResellerController@index')
			->middleware('permission:' . config('app.reseller_create'))->name('resellers.create');

			Route::get('/priceLists/provider/{provider}', 'PriceListController@getProviderPriceList')
			->middleware('permission:' . config('app.price_list_show'))->name('priceLists.provider_price_list');

			Route::resource('/priceLists', 'PriceListController');
		});

	});

	/*****************************************************************************************************************/

	// Routes that platform managers, providers and resellers can access
	Route::group(['middleware' => ['role:' . config('app.super_admin') . '|' . config('app.admin' ) . '|' . config('app.provider' ) . '|' . config('app.reseller') . '|' . config('app.subreseller')]], function () {

		Route::get('/resellers', 'ResellerController@index')
		->middleware('permission:' . config('app.reseller_index'))->name('resellers.index');

		Route::get('/customers', 'CustomerController@index')
		->middleware('permission:' . config('app.customer_index'))->name('customers.index');


		Route::group(['middleware' => ['check_reseller']], function () {

			Route::get('/resellers/{reseller}-{slug}', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_show'))->name('resellers.show');

			Route::get('resellers/{reseller}-{slug}/edit', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_edit'))->name('resellers.edit');

			Route::get('resellers/{reseller}-{slug}/customers', 'ResellerController@getCustomersFromReseller')
			->middleware('permission:' . config('app.customer_index'))->name('resellers.customers');

			Route::get('/priceLists/reseller/{reseller}', 'PriceListController@getResellerPriceList')->name('priceLists.reseller_price_list');

		});

		Route::group(['middleware' => ['check_customer']], function () {
			Route::get('/priceLists/customer/{customer}', 'PriceListController@getCustomerPriceList')->name('priceLists.customer_price_list');
		});

	});

	/*****************************************************************************************************************/

	// Routes that platform managers, providers, resellers and customers can access
	Route::group(['middleware' => ['role:Super Admin|Admin|Provider|Reseller|Sub Reseller|Customer']], function () {

		Route::group(['middleware' => ['check_customer']], function () {

			Route::get('/customers/{customer}-{slug}', 'CustomerController@show')
			->middleware('permission:' . config('app.customer_show'), 'check_customer')
			->name('customers.show');

			Route::get('customers/{customer}-{slug}/edit', 'CustomerController@show')
			->middleware('permission:' . config('app.customer_edit'))
			->name('customers.edit');

		});

	});

	/*****************************************************************************************************************/

});
Auth::routes();


