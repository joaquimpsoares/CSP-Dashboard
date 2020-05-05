<?php

use App\Customer;
use App\Notifications\FailedJob;
use App\Jobs\PlaceOrderMicrosoft;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CreateCustomerMicrosoft;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notification;

//Marco verifica aqui esta linha... para a importação dos productos!


Route::get('/jobs', 'JobsController@index')->name('jobs');
Route::get('jobs/retry/{id}', 'JobsController@retryJob')->name('jobs.retry');
Route::get('jobs/pending', 'JobsController@pending')->name('jobs.pending');
Route::get('jobs/destroy/{id}', 'JobsController@destroy')->name('jobs.destroy');

Route::post('provider/register', 'ProviderController@store')->name('provider.register');

Route::resource('/user', 'UsersController');

Route::post('registerInvitation', 'UsersController@registerInvitation')->name('registerInvitation');

Route::get('/sendnoti', function() {
	
	// $cust = Customer::where('id', "310000")->first();
	// // dd($cust);
	// $cust->tenant_id  =  'a3bcd293-ca47-4b54-b794-c2afabd4bc5e';
	// $cust->tenant_user = "admin@tagydessssssftbhgb.onmicrosoft.com";
	// $cust->save();
	
	PlaceOrderMicrosoft::dispatch()->onQueue('OrderCustomer')
	->delay(now()->addSeconds(10));            
})->name('sendnoti');


Route::get('invite', 'InviteController@invite')->name('invite');
Route::post('invite', 'InviteController@process')->name('process');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'InviteController@accept')->name('accept');



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
			
			Route::get('/customer/{customer}/priceList', 'CustomerController@getPriceList')->name('customer.pricelist');
			
			/*
			fim Confirmar nivel de acesso reseller->provider
			*/
		});
		
	});
	
	/*****************************************************************************************************************/
	
	// Every authenticated user can access routes here
	
	Route::get('/order/placeOrder/{cart}', 'OrderController@placeOrder')->name('order.place_order');
	
	Route::get('/home', 'HomeController@index')->name('home');
	
	Route::get('cart/pending', 'CartController@getPending')->name('cart.pending');
	Route::get('cart/item/changeBillingCycle', 'CartController@changeBillingCycle')->name('cart.main_user');
	Route::get('/cart/customer/mainUser', 'CartController@getMainUser')->name('cart.main_user');
	Route::post('/cart/product/add', 'CartController@addProductToCart')->name('cart.add_to_cart');
	Route::get('/cart/item/{id}/quantity/{quantity}', 'CartController@changeProductQuantity');
	Route::get('/cart/add/product/{product}', 'CartController@addProduct')->name('cart.add_product');
	Route::get('/cart/remove/item/{item}', 'CartController@removeItem')->name('cart.remove_product');
	Route::get('/cart/clear', 'CartController@destroy')->name('cart.clear');
	Route::post('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
	Route::post('/cart/pending/checkout', 'CartController@pendingCheckout')->name('cart.pending_checkout');
	Route::get('/cart/customer/{customer}/add', 'CartController@addCustomer')->name('cart.add_customer');
	Route::get('/cart/checkDomainAvailability', 'CartController@checkDomainAvailability')->name('cart.check_domain_availability');
	Route::post('/cart/addMCAUser', 'CartController@addMCAUser')->name('cart.add_mca_user');
	
	
	Route::resource('/cart', 'CartController');
	Route::resource('/store', 'StoreController');
	Route::get('products/test', 'ProductController@index2');
	Route::resource('product', 'ProductController');
	
	// End of every authenticated user can access routes here
});


Auth::routes(['register' => false]);

Route::impersonate();

Route::get('/', function() {
	return view('home');
})->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
