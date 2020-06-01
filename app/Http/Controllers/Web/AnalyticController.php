<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\AzureResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleNotifyAzure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Customer;
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
        // dd($resourceName);
        // $date = AzureResource::selectRaw('DATE_FORMAT(azure_updated_at, "%d-%b-%Y") as date')->first();
        
        $category = array_column($query, 'category');
        $sum = array_column($query, 'sum');
        
        $top10C = array_column($top10Q, 'category');
        $top10S = array_column($top10Q, 'sum');
        
        
        // TODO: cache key should be dynamic by customer
        $budget = cache()->remember('azure.budget', 0, function(){
            
            $customer = new TagydesCustomer([
                'id' => 'd9b842d6-aa51-44ca-a77c-f7d20411b942',
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
            'customerId'    => "d9b842d6-aa51-44ca-a77c-f7d20411b942",
            'name'          => "5trvfvczdfv",
            'status'        => "5trvfvczdfv",
            'quantity'      => "1",
            'currency'      => "EUR",
            'billingCycle'  => "monthly",
            'created_at'    => "5trvfvczdfv",
            ]);
            
            return (int) FacadesAzureResource::withCredentials(
                "66127fdf-8259-429c-9899-6ec066ff8915",
                "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfALw.AQABAAAAAABeAFzDwllzTYGDLh_qYbH8FeLygiGNRfXCDRnVOpN62d3xlNaszrjSyFT8UzPwsgm61N1OPMy7_thY22wjSIGjYMMpOmPc4gyuRHYyFjJY6LJTpupg2mPir6TqiEfQWC2-sAJM1IGSP-Slfd2ngy-SkPwHWOIOefRKNwoP7mTUHf4ywRaw30vS0QGHtOdF6-PERdTryy2mKxb86r9OEAmnQQbcfIg2mrtqYyK0BWaJUYxBD8ULxo-acgArcZKC4vPYh-Z-qtOCdI2-NcOq47aCqQnNwiUiz5TMJ3WV1guDcfTarmxiBE2JbnS6-FxggqDNoVh13q2TcxZcfMwaN2fGR_z_q1HDJvMJZJTmbbpf8_Dh1Ls1vOEriEIzGykyyUT0zKFEMVau1z77leEEuMhx0E5YUHJUu8KPgXnCXIwo9wUfWP3pet67wmHd9lnMpoXDbdIb2LzCcuRE-jJzWjap5BL4rb-H0uyMev-4AwgUO4ud1QYD93uyIDuOOezBjfDENB-a-2iOIimQ2x-mwgP0g8tCdngg9qetEsX3mHSc7EB5eeS4vEQTmvcEazKoGtSWwcpX9rcBbiapbEBgWMTQ9BFo_SXxEtdoQdO2W1HtTaBmVLnjZjf4AqE8Uv9A7EAmyB7xGW-a04aL0qfT_wy2hTxZNpY0QFIJ4O1EvZxRZg2VNgZha3AHnEPg7hhqbhBnO48kyo6ENtsVLipB_SwU-HcFRUECp_q2v5DAp27Tjz69vcnOJve0VLr-g49MKsXubspL5OvvjJKJMtg3UcF5m8yJsqlTojkpgKCF94_W6_PNFwLLjvBw6C3vPSml7Nz9ejZUmECiyEJlpBrEf0NUl7cLOfa833cW92GTWCg49pMqC_g8mForzHTHCsHLaOXN68d-oH9w_jdzqaecR9tht84kBL-YgUhs4QIIV1HKE4CjGT4Ahuapk0vGJxsDQvIvPvgcTpra-X1Stu3sm6FflIvDw2CHj5XA8TJ6suBWOBJlL0vj0tnsRj41H12n09T-F0Su3aiSBcxJ4APCG9U2IAA"
                )->budget($customer, $subscription);
            });
                    
                    
        $costSum = AzureResource::sum('cost');
        // $costSum = "3000";
        
        $increase = ($budget-$costSum);
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
    
    
    /**
    *
    */
    Public function UpdateAZURE()
    {
                        
        // dd($customer);
        $customer = new TagydesCustomer([
            'id' => 'd9b842d6-aa51-44ca-a77c-f7d20411b942',
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
            'customerId'    => "d9b842d6-aa51-44ca-a77c-f7d20411b942",
            'name'          => "5trvfvczdfv",
            'status'        => "5trvfvczdfv",
            'quantity'      => "1",
            'currency'      => "EUR",
            'billingCycle'  => "monthly",
            'created_at'    => "5trvfvczdfv",
            ]);
            
        $resources = FacadesAzureResource::withCredentials(
            "66127fdf-8259-429c-9899-6ec066ff8915",
            "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfALw.AQABAAAAAABeAFzDwllzTYGDLh_qYbH8FeLygiGNRfXCDRnVOpN62d3xlNaszrjSyFT8UzPwsgm61N1OPMy7_thY22wjSIGjYMMpOmPc4gyuRHYyFjJY6LJTpupg2mPir6TqiEfQWC2-sAJM1IGSP-Slfd2ngy-SkPwHWOIOefRKNwoP7mTUHf4ywRaw30vS0QGHtOdF6-PERdTryy2mKxb86r9OEAmnQQbcfIg2mrtqYyK0BWaJUYxBD8ULxo-acgArcZKC4vPYh-Z-qtOCdI2-NcOq47aCqQnNwiUiz5TMJ3WV1guDcfTarmxiBE2JbnS6-FxggqDNoVh13q2TcxZcfMwaN2fGR_z_q1HDJvMJZJTmbbpf8_Dh1Ls1vOEriEIzGykyyUT0zKFEMVau1z77leEEuMhx0E5YUHJUu8KPgXnCXIwo9wUfWP3pet67wmHd9lnMpoXDbdIb2LzCcuRE-jJzWjap5BL4rb-H0uyMev-4AwgUO4ud1QYD93uyIDuOOezBjfDENB-a-2iOIimQ2x-mwgP0g8tCdngg9qetEsX3mHSc7EB5eeS4vEQTmvcEazKoGtSWwcpX9rcBbiapbEBgWMTQ9BFo_SXxEtdoQdO2W1HtTaBmVLnjZjf4AqE8Uv9A7EAmyB7xGW-a04aL0qfT_wy2hTxZNpY0QFIJ4O1EvZxRZg2VNgZha3AHnEPg7hhqbhBnO48kyo6ENtsVLipB_SwU-HcFRUECp_q2v5DAp27Tjz69vcnOJve0VLr-g49MKsXubspL5OvvjJKJMtg3UcF5m8yJsqlTojkpgKCF94_W6_PNFwLLjvBw6C3vPSml7Nz9ejZUmECiyEJlpBrEf0NUl7cLOfa833cW92GTWCg49pMqC_g8mForzHTHCsHLaOXN68d-oH9w_jdzqaecR9tht84kBL-YgUhs4QIIV1HKE4CjGT4Ahuapk0vGJxsDQvIvPvgcTpra-X1Stu3sm6FflIvDw2CHj5XA8TJ6suBWOBJlL0vj0tnsRj41H12n09T-F0Su3aiSBcxJ4APCG9U2IAA"
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
        $value = $request->budget;
        $customer = new TagydesCustomer([
            'id' => 'd9b842d6-aa51-44ca-a77c-f7d20411b942',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);
                                            
    $result = FacadesAzureResource::withCredentials(
        "66127fdf-8259-429c-9899-6ec066ff8915",
        "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfALw.AQABAAAAAABeAFzDwllzTYGDLh_qYbH8FeLygiGNRfXCDRnVOpN62d3xlNaszrjSyFT8UzPwsgm61N1OPMy7_thY22wjSIGjYMMpOmPc4gyuRHYyFjJY6LJTpupg2mPir6TqiEfQWC2-sAJM1IGSP-Slfd2ngy-SkPwHWOIOefRKNwoP7mTUHf4ywRaw30vS0QGHtOdF6-PERdTryy2mKxb86r9OEAmnQQbcfIg2mrtqYyK0BWaJUYxBD8ULxo-acgArcZKC4vPYh-Z-qtOCdI2-NcOq47aCqQnNwiUiz5TMJ3WV1guDcfTarmxiBE2JbnS6-FxggqDNoVh13q2TcxZcfMwaN2fGR_z_q1HDJvMJZJTmbbpf8_Dh1Ls1vOEriEIzGykyyUT0zKFEMVau1z77leEEuMhx0E5YUHJUu8KPgXnCXIwo9wUfWP3pet67wmHd9lnMpoXDbdIb2LzCcuRE-jJzWjap5BL4rb-H0uyMev-4AwgUO4ud1QYD93uyIDuOOezBjfDENB-a-2iOIimQ2x-mwgP0g8tCdngg9qetEsX3mHSc7EB5eeS4vEQTmvcEazKoGtSWwcpX9rcBbiapbEBgWMTQ9BFo_SXxEtdoQdO2W1HtTaBmVLnjZjf4AqE8Uv9A7EAmyB7xGW-a04aL0qfT_wy2hTxZNpY0QFIJ4O1EvZxRZg2VNgZha3AHnEPg7hhqbhBnO48kyo6ENtsVLipB_SwU-HcFRUECp_q2v5DAp27Tjz69vcnOJve0VLr-g49MKsXubspL5OvvjJKJMtg3UcF5m8yJsqlTojkpgKCF94_W6_PNFwLLjvBw6C3vPSml7Nz9ejZUmECiyEJlpBrEf0NUl7cLOfa833cW92GTWCg49pMqC_g8mForzHTHCsHLaOXN68d-oH9w_jdzqaecR9tht84kBL-YgUhs4QIIV1HKE4CjGT4Ahuapk0vGJxsDQvIvPvgcTpra-X1Stu3sm6FflIvDw2CHj5XA8TJ6suBWOBJlL0vj0tnsRj41H12n09T-F0Su3aiSBcxJ4APCG9U2IAA"
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
                                                        
        $budget = cache()->remember('azure.budget', 0, function(){
            
            $customer = new TagydesCustomer([
                'id' => 'd9b842d6-aa51-44ca-a77c-f7d20411b942',
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
                'customerId'    => "d9b842d6-aa51-44ca-a77c-f7d20411b942",
                'name'          => "5trvfvczdfv",
                'status'        => "5trvfvczdfv",
                'quantity'      => "1",
                'currency'      => "EUR",
                'billingCycle'  => "monthly",
                'created_at'    => "5trvfvczdfv",
                ]);
                
                return (int) FacadesAzureResource::withCredentials(
                    "66127fdf-8259-429c-9899-6ec066ff8915",
                    "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfALw.AQABAAAAAABeAFzDwllzTYGDLh_qYbH8FeLygiGNRfXCDRnVOpN62d3xlNaszrjSyFT8UzPwsgm61N1OPMy7_thY22wjSIGjYMMpOmPc4gyuRHYyFjJY6LJTpupg2mPir6TqiEfQWC2-sAJM1IGSP-Slfd2ngy-SkPwHWOIOefRKNwoP7mTUHf4ywRaw30vS0QGHtOdF6-PERdTryy2mKxb86r9OEAmnQQbcfIg2mrtqYyK0BWaJUYxBD8ULxo-acgArcZKC4vPYh-Z-qtOCdI2-NcOq47aCqQnNwiUiz5TMJ3WV1guDcfTarmxiBE2JbnS6-FxggqDNoVh13q2TcxZcfMwaN2fGR_z_q1HDJvMJZJTmbbpf8_Dh1Ls1vOEriEIzGykyyUT0zKFEMVau1z77leEEuMhx0E5YUHJUu8KPgXnCXIwo9wUfWP3pet67wmHd9lnMpoXDbdIb2LzCcuRE-jJzWjap5BL4rb-H0uyMev-4AwgUO4ud1QYD93uyIDuOOezBjfDENB-a-2iOIimQ2x-mwgP0g8tCdngg9qetEsX3mHSc7EB5eeS4vEQTmvcEazKoGtSWwcpX9rcBbiapbEBgWMTQ9BFo_SXxEtdoQdO2W1HtTaBmVLnjZjf4AqE8Uv9A7EAmyB7xGW-a04aL0qfT_wy2hTxZNpY0QFIJ4O1EvZxRZg2VNgZha3AHnEPg7hhqbhBnO48kyo6ENtsVLipB_SwU-HcFRUECp_q2v5DAp27Tjz69vcnOJve0VLr-g49MKsXubspL5OvvjJKJMtg3UcF5m8yJsqlTojkpgKCF94_W6_PNFwLLjvBw6C3vPSml7Nz9ejZUmECiyEJlpBrEf0NUl7cLOfa833cW92GTWCg49pMqC_g8mForzHTHCsHLaOXN68d-oH9w_jdzqaecR9tht84kBL-YgUhs4QIIV1HKE4CjGT4Ahuapk0vGJxsDQvIvPvgcTpra-X1Stu3sm6FflIvDw2CHj5XA8TJ6suBWOBJlL0vj0tnsRj41H12n09T-F0Su3aiSBcxJ4APCG9U2IAA"
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
                //     dd("this is s");
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
