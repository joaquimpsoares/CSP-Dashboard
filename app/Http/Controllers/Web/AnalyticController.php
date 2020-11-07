<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\AzureResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleNotifyAzure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Customer;
use App\Instance;
use App\Subscription;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;
// use Tagydes\MicrosoftConnection\Repositories\AzureResource\RestV1AzureResourceRepository;


class AnalyticController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
       

        $query = AzureResource::groupBy('category')->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->get()->toArray();
        $top10Q = AzureResource::groupBy('category')->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->limit(10)->get()->toArray();
        $msdate = AzureResource::select('azure_updated_at')->first();
        $dateupdated = AzureResource::select('updated_at')->first();
        
        $resourceName = AzureResource::groupBy('name')->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->get();
        // $date = AzureResource::selectRaw('DATE_FORMAT(azure_updated_at, "%d-%b-%Y") as date')->first();
        
        $category = array_column($query, 'category');
        $sum = array_column($query, 'sum');
        
        $top10C = array_column($top10Q, 'category');
        $top10S = array_column($top10Q, 'sum');
        
        
        // TODO: cache key should be dynamic by customer
        $budget = cache()->remember('azure.budget', 0, function(){
            
            $customer = new TagydesCustomer([
                'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);
                
        $subscription = new TagydesSubscription([
            'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
            'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
            'name'          => "5trvfvczdfv",
            'status'        => "5trvfvczdfv",
            'quantity'      => "1",
            'currency'      => "EUR",
            'billingCycle'  => "monthly",
            'created_at'    => "5trvfvczdfv",
            ]);
            
            
            $subscriptions = Subscription::select('instance_id')->first();
        
            $instance = Instance::where('id', $subscriptions->instance_id)->first();
            return (int) FacadesAzureResource::withCredentials(
                $instance->external_id,$instance->external_token
                )->budget($customer, $subscription);
            });
                    
                    
        $costSum = AzureResource::sum('cost');
        // $costSum = "3000";
        
        $increase = ($budget-$costSum);

        
        if($increase !== 0){
            $average1 = ($increase/$budget)*100;
            $average = 100-$average1;

            return view('analytics.azure', [
                'category' => json_encode($category, JSON_NUMERIC_CHECK),
                'query' => json_encode($query, JSON_NUMERIC_CHECK),
                'top10q'=> json_encode($top10Q, JSON_NUMERIC_CHECK),
                'sum' => json_encode($sum, JSON_NUMERIC_CHECK),
                'total' => $costSum,
                'budgetAndTotal' => json_encode([$budget, $budget - $costSum ], JSON_NUMERIC_CHECK),
                'budget' => $budget,
                'date' => $msdate,
                'dateupdated' => $dateupdated,
                'resourceName' => $resourceName,
                'average' => (int) $average,
            
                'top10C' => json_encode($top10C, JSON_NUMERIC_CHECK),
                'top10S' => json_encode($top10S, JSON_NUMERIC_CHECK)
                ]);
            }
        
                    
                    
    return view('analytics.azure', [
        'category' => json_encode($category, JSON_NUMERIC_CHECK),
        'query' => json_encode($query, JSON_NUMERIC_CHECK),
        'top10q'=> json_encode($top10Q, JSON_NUMERIC_CHECK),
        'sum' => json_encode($sum, JSON_NUMERIC_CHECK),
        'total' => $costSum,
        'budgetAndTotal' => json_encode([$budget, $budget - $costSum ], JSON_NUMERIC_CHECK),
        'budget' => $budget,
        'date' => $msdate,
        'dateupdated' => $dateupdated,
        'resourceName' => $resourceName,
        'average' => (int) ['0'],
        'top10C' => json_encode($top10C, JSON_NUMERIC_CHECK),
        'top10S' => json_encode($top10S, JSON_NUMERIC_CHECK)
        ]);
    }
    
    
    /**
    *
    */
    Public function UpdateAZURE()
    {
        $subscriptions = Subscription::select('instance_id')->first();
        
            $instance = Instance::where('id', 4)->first();
                        
        $customer = new TagydesCustomer([
            'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);
                            
        $subscription = new TagydesSubscription([
            'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
            'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
            'name'          => "5trvfvczdfv",
            'status'        => "5trvfvczdfv",
            'quantity'      => "1",
            'currency'      => "EUR",
            'billingCycle'  => "monthly",
            'created_at'    => "5trvfvczdfv",
            ]);
            

            $subscriptions = Subscription::select('instance_id')->first();
        
            $instance = Instance::where('id', $subscriptions->instance_id)->first();
            
        $resources = FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->all($customer, $subscription);
        
        $resources->each(function($resource){
            AzureResource::updateOrCreate([
                'azure_id' => $resource->id
            ], [
                'name' => $resource->name,
                'category' => $resource->category,
                'unit' => $resource->unit,
                'subcategory' => $resource->subcategory,
                'currency' => $resource->currencyLocale,
                'cost' => $resource->totalCost,
                'used' => $resource->quantityUsed,
                'azure_updated_at' => Carbon::parse($resource->lastModifiedDate),
                ]);
            }); 
        return back()->withInput();
    }
                                    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request)
    {

        $subscriptions = Subscription::select('instance_id')->first();
        
            $instance = Instance::where('id', 1)->first();

        $value = $request->budget;
        $customer = new TagydesCustomer([
            'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);
                                            
    $result = FacadesAzureResource::withCredentials(
        $instance->external_id,$instance->external_token
            )->changeBudget($customer, $value);
        
        $budget = $result;
        
        return back()->with(compact('budget'));
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }
                                            
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show()
    {
        
        $subscriptions = Subscription::select('instance_id')->first();
        
        
        $budget = cache()->remember('azure.budget', 0, function(){
            
            $customer = new TagydesCustomer([
                'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);
                
                $subscription = new TagydesSubscription([
                    'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
                    'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
                    'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
                    'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
                    'name'          => "5trvfvczdfv",
                    'status'        => "5trvfvczdfv",
                    'quantity'      => "1",
                    'currency'      => "EUR",
                    'billingCycle'  => "monthly",
                    'created_at'    => "5trvfvczdfv",
                    ]);
                    
                    $instance = Instance::where('id', 4)->first();
                return (int) FacadesAzureResource::withCredentials(
                    $instance->external_id,$instance->external_token
            )->budget($customer, $subscription);
                });
                
                
                $costSum = AzureResource::sum('cost');
                // $costSum = "500";
                
                $increase = ($budget-$costSum);
                $average1 = ($increase/$budget)*100;
                $average = 100-$average1;
                
                $customer = Customer::first();
                
                
                $data = ([
                    'customer'=> $customer,
                    'average' => (int) $average,
                    'costSum' => $costSum,
                    'budget'  => $budget
                    ]);
                                                                
        // if ($average > 80) {
            //     Mail::to('joaquim.soares@tagydes.com')->send(new ScheduleNotifyAzure($data));
            
            //     return redirect('analytics')
            //         ->with('message', 'Thanks for your message. We\'ll be in touch.');
            // }else{
                // }
                
            }
            
            
            
            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function update(Request $request, $id)
            {
                //
            }
                                                                    
        /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id)
        {
            //
        }
    }
