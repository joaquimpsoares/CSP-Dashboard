<?php

use App\Cart;
use App\Tier;
use App\Order;
use App\Price;
use App\Product;
use App\Customer;
use App\Instance;
use App\PriceList;
use Carbon\Carbon;
use App\Subscription;
use App\MicrosoftTenantInfo;
use App\KasperskyLincenseInfo;
use App\Jobs\PlaceOrderMicrosoft;
use App\kaspersky_lincense_infos;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Tagydes\KasperskyConnection\Facades\Order as KasOrder;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;


// Route::prefix('jobs')->group(function () {
//     Route::queueMonitor();
// });

//Marco verifica aqui esta linha... para a importação dos productos!

// Route::resource('/analytics', 'AnalyticController');





Route::post('registerInvitation', 'UsersController@registerInvitation')->name('registerInvitation');


Route::get('invite', 'InviteController@invite')->name('invite');
Route::post('invite', 'InviteController@process')->name('process');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'InviteController@accept')->name('accept');



/**********************************************************************************
Início Rotas que necessitam ser verificadas e inseridas em seus devídos midlewares groups

**********************************************************************************/


Route::get('/servicecosts', function()
{


    $instance = Instance::where('id', '3')->first();

    $customer = new TagydesCustomer([
        'id' => 'd09c8a90-cd32-4aaa-a54e-1959632f651b',
        'username' => 'bill@tagydes.com',
        'password' => 'blabla',
        'firstName' => 'Nombre',
        'lastName' => 'Apellido',
        'email' => 'bill@tagydes.com',
        ]);

    $test = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceCosts($customer);
    return $test;

});


Route::get('/test', function() {

	$instance=Instance::where('type', 'kaspersky')->first();
	$certificate=Instance::select('certificate')->where('type', 'kaspersky')->first();

	$certificate = Crypt::decryptString($certificate->certificate);
	$url=Instance::select('external_url')->where('type', 'kaspersky')->first();

	// $id = 'KL4536XAEMG'; //monthly
	$id = 'KL4536XAMFG'; //yearly

	$quantity = '15';

	$product = Price::where('product_sku', $id)->first();



	$tiers = $product->tiers;

	$tier = $tiers->filter(function($value){
		return true;
	});


	$tier = $tiers->filter(function($tier) use ($quantity) {
		return $quantity >= $tier->min_quantity && $quantity < $tier->max_quantity;
	})->first();


	$customer = Customer::where('id', 310000)->first();


	$newCustomer = Tagydeskasp::withCredentials($url, $certificate)->create([
		"BillingPlan" => "yearly",
		"Sku"=> $tier->product_sku,
		"Quantity"=> $quantity,
		"CompanyName"=> $customer->company_name,
		"Email"=> "joaquim.soares@tagydes.com",
		"Phone"=> "600032256",
		"CustomerCode"=> $customer->id,
		"AddressLine1"=> $customer->address_1,
		"AddressLine2"=> $customer->address_2,
		"City"=> $customer->city,
		"State"=> $customer->state,
		"Zip"=> $customer->postal_code,
		"Country" => $customer->country->iso_3166_3,
		"Partner"=> $instance->tenant_id,
		"Reseller"=> "TE27PT00",
		"ExternalSubscriptionId"=>  "string",
		"ExternalOrderId"=> "string",
		"ExternalLineItemId"=> "string",
		"AgreementAccepted"=> true,
		"AgreementText"=> "string",
		"AgreementTextHash"=> "string",
		// "ApprovalCode"=>  "ApprovalCode@TAGYDES@6",
		"DeliveryEmail"=> "joaquim.soares@tagydes.com"
		]);


		// $result =


	$kas_details = KasperskyLincenseInfo ::create([
		'subscriptionid' => $newCustomer->SubscriptionId,
		'activationcode' => $newCustomer->ActivationCode,
		'licenseid' => $newCustomer->LicenseId,
		'customer_id' => $customer->id,
	]);
	dd($kas_details);
	// dd($instance->external_token);
	// $orderConfirm = KasOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($kas_details);
	// Log::info('Confirmation of cart Cart: '.$orderConfirm);

	dd($newCustomer);


	foreach ($newCustomer->subscriptions() as $subscription)
            {
                $subscriptions = new Subscription();
                $subscriptions->name = 				$subscription->name;
                $subscriptions->subscription_id = 	$subscription->id;
                $subscriptions->customer_id = 		$customer->id; //customer id from request recieved from Microsoft
                $subscriptions->product_id = 		$subscription->offerId;
                $subscriptions->instance_id =		$product->instance_id;
                $subscriptions->billing_type =      $product->billing;
                $subscriptions->order_id = 			$subscription->orderId;
                $subscriptions->amount = 			$subscription->quantity;
                $subscriptions->expiration_data	=	Carbon::now()->addYear()->toDateTimeString(); //Set subscription expiration date
                $subscriptions->billing_period = 	$subscription->billingCycle;
                $subscriptions->currency = 			$subscription->currency;
                $subscriptions->tenant_name	=		$this->order->domain;
				$subscriptions->status_id =         1;
                $subscriptions->save();
				// dd($subscription);
			}

	// $result = Subscription::create([
	// 	'subscription_id' => $newCustomer->SubscriptionId,
	// 	'customer_id' => $customer->id,
	// 	'product_id' => $tier->product_sku,
	// 	'amount' => $quantity,
	// 	'instance_id' => $product->instance_id,
	// 	'billing_period' => $product->product->supported_billing_cycles->first(),
	// 	'billing_type' => $product->product->billing,
	// ]);

// dd($result);

});
/**********************************************************************************
Fim Rotas que necessitam ser verificadas e inseridas em seus devídos midlewares groups

**********************************************************************************/
use Tagydes\KasperskyConnection\Facades\Customer as Tagydeskasp;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;

Route::get('login/microsoft', [LoginController::class, 'redirectToProvider']);
Route::get('login/microsoft/callback', [LoginController::class, 'handleProviderCallback']);

Route::get('login/graph', [LoginController::class, 'redirectToProvider']);
Route::get('login/graph/callback', [LoginController::class, 'handleProviderCallback']);


Route::group(['middleware' => 'auth'], function () {


	/*****************************************************************************************************************/

	// Routes that only platform managers can access
	Route::group(['middleware' => ['role:Super Admin']], function () {

		Route::resource('roles', 'RoleController');
		Route::post('roles/update/all', 'RoleController@updateAll')->name('roles.update.all');
		Route::resource('permissions', 'PermissionController');
        Route::get('userloginfo', 'HomeController@userLogInfo')->name('userloginfo');
        Route::get('logactivity', 'HomeController@logActivity')->name('logactivity');


	});

	/*****************************************************************************************************************/

	// Routes that platform managers and administrators can access
	Route::group(['middleware' => ['role:Super Admin|Admin']], function () {

		Route::resource('provider', 'ProviderController');


	});

	/*****************************************************************************************************************/

	// Routes that platform managers and providers can access
	Route::group(['middleware' => ['role:Super Admin|Admin|Provider']], function () {

		Route::get('/instances/kascreate', 'InstanceController@kascreate')->name('instances.kascreate');
			Route::resource('/instances', 'InstanceController');

            Route::get('/product/import/{provider_id}', 'ProductController@import')->name('product.import');

			Route::get('/instances/getMasterToken/{provider_id}', 'InstanceController@getMasterToken')->name('instances.getMasterToken');

			Route::get('/reseller/create', 'ResellerController@create')
				->middleware('permission:' . config('app.reseller_create'))->name('reseller.create');

			Route::post('/reseller', 'ResellerController@store')
				->middleware('permission:' . config('app.reseller_create'))->name('reseller.store');

			Route::group(['middleware' => ['check_provider']], function () {




			/*Route::get('/priceList/provider/{provider}', 'PriceListController@getProviderPriceList')
			->middleware('permission:' . config('app.price_list_show'))->name('priceLists.provider_price_list');*/

            // route::get('scheduler', '\vendor\MatviiB\Scheduler\Controllers\SchedulerController@index')->name("scheduler.index");


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

		Route::post('pricelist/storePriceList', 'PriceListController@storePriceList')->name('priceList.storePriceList');


		Route::group(['middleware' => ['check_reseller']], function () {


			// Route::resource('reseller', 'ResellerController');


			Route::get('/reseller/{reseller}-{slug}', 'ResellerController@show')
			->middleware('permission:' . config('app.reseller_show'))->name('reseller.show');

			Route::patch('/reseller/update/{reseller}', 'ResellerController@update')
			->name('reseller.update');

			Route::get('reseller/{reseller}-{slug}/edit', 'ResellerController@edit')
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

        Route::get('/customer/serviceCostsLineitems/{id}', 'CustomerController@serviceCostsLineitems')
        ->name('customer.serviceCostsLineitems');
		Route::group(['middleware' => ['check_customer']], function () {


			Route::get('/customer/{customer}-{slug}', 'CustomerController@show')
			->middleware('permission:' . config('app.customer_show'), 'check_customer')
            ->name('customer.show');



//need to check permissions has a reseller to be able tp edit.... customer_update
			Route::post('customer/update/{customer}', 'CustomerController@update')
			->middleware('permission:' . config('app.customer_show'))
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
	Route::get('/subscription.card', 'SubscriptionController@card')->middleware('permission:' . config('app.subscription_edit'))->name('subscription.card');

	Route::resource('/cart', 'CartController');

	Route::get('/store/categories/{vendor}', 'StoreController@categories')->name('store.categories');
	Route::get('/store/searchstore/{vendor}/{category}', 'StoreController@searchstore')->name('store.searchstore');

	Route::resource('/store', 'StoreController');

	Route::get('products/test', 'ProductController@index2');
	Route::get('products/{id}', 'ProductController@show');

	Route::resource('product', 'ProductController');
    Route::resource('/order', 'OrderController');

    Route::get('/analytics', [
        'uses' => 'AnalyticController@index',
        'as' => 'analytics.list'
    ]);

    Route::get('/analytics/update', [
        'uses' => 'AnalyticController@updateAZURE',
        'as' => 'analytics.update'
    ]);

    Route::get('/analytics/licenses', [
        'uses' => 'AnalyticController@licenses',
        'as' => 'analytics.licenses'
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

    Route::resource('/price', 'PriceController');


    Route::get('jobs', 'JobsController@index')->name('jobs');
    Route::get('jobs/retry/{id}', 'JobsController@retryJob')->name('jobs.retry');
    Route::get('jobs/pending', 'JobsController@pending')->name('jobs.pending');
    Route::get('jobs/destroy/{id}', 'JobsController@destroy')->name('jobs.destroy');

    Route::post('provider/register', 'ProviderController@store')->name('provider.register');

    Route::resource('/user', 'UsersController');

    Route::get('/user/profile/{user}', 'UsersController@profile')->name('user.profile');
    Route::post('/user/updatepassword/{user}', 'UsersController@updatepassword')->name('user.updatepassword');

	// End of every authenticated user can access routes here
	});


	Auth::routes(['register' => true]);

	Route::impersonate();

	// Route::get('/{lang}', 'HomeController@index', function ($lang) {
	// 	App::setlocale($lang);
	// })->name('home');

	Route::get('/', 'HomeController@index')->name('home');

	Route::get('/home', 'HomeController@index')->name('home');

	Auth::routes();
