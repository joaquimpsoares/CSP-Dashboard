<?php

use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use App\PriceList;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CreateProviderResellerCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::unsetEventDispatcher();

        $active = Status::where('name', 'messages.active')->first();


        $provider = Provider::create([
    		'company_name' => 'Provider 1',
    		'address_1' => 'Address',
    		'address_2' => 'complment',
    		'country_id' => '724',
    		'state' => 'Madrid',
    		'city' => 'Madrid',
    		'nif' => '12345',
    		'postal_code' => '28000',
    		'status_id' => $active->id,
    	]);

        $provider2 = Provider::create([
            'company_name' => 'Provider 2',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12344',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        Instance::create([
            'name' => 'Tagydes TIPS',
            'type' => 'microsoft',
            'provider_id' => 1,
            // 'tenant_id' => 'bdaf0f95-e7b3-47c9-a22e-8bf43c272809', // Tenant CBI
            'tenant_id' => '3ba0b5ee-443a-4350-9b2b-34bde19a0a49',
            'external_id' => '66127fdf-8259-429c-9899-6ec066ff8915',
            'external_type' => 'direct',
            // 'external_token' => 'AQABAAAAAAAm-06blBE1TpVMil8KPQ41y4HxE4_aJdIAQ6BHM6f0BELfqHh13KVkmEczgmbyySx6JQUGxlCrFNKq1eCMuAV0BLIR5rjvbglwROt1mNzgsU5ZNK4ueWgjTO1RYoVtG8iKcSXEXKUsUWi3H_Gb_To6GPmxcJik1AvwLTHJycD-snQkoYS9KTJEpKzkViwXD4h1kJ8vGpY-Qrk_wK4wLhACLuk-ZndCkSIAsN5Kv2PKayZko9a5wQvUB5fiOfCdGsXNwDKFCqP7lIYhMyfCIBJGgPwvA_wpBBYZrxTbqUVlXdo6NrF1zhli2u_j8S8r3fpT48SkDp0qsh8R7AGe636vGpIQM9WU_xlbentFMNk8EKUUGipRTY-zn-0UU_u0zt8itpTa0CKSxYw1vZ5AweUFMXur9uL0h9xu5G1zKbZ3DYtNYokvJVsB_uCZGKIuXEew4wb8Ct0QMryLdq-x9xZEEbDaPR0c0EREdzpQCKC1jdL9CBA2zpQhcvvkcjIOipdXMIs5rYRsz6ob1ZuvFQRcobAeOV2ArtGJdrcR_s4LLVIcO5DN2m6jj7snkmchieEYNRU_0kThpgtYyG8bVHEh2sp-tdAJkPjCZHh1nF_OLrCOYdJd2-9wSpisWsnMUk3qSEJiqTktrjVg_Zc3BhQuJ90bfqXe1NyHxkdPNTFQ8I5PjJyYIcW5Sim6u_GM8tT1PnL6tWfZVWOEB6kodw-2eqaTGJ3pZLbGL1SrhKXfL8c6beNBfjKZNQbQTOPcIkp-QywNwRuOYhQd1D3dXF2wyuEIqLntGjwyui1qFkZaDbsNc41qdfhbvFAZbH8U-fqYi36R5vaIWA-KfhD-OW0kg7M-dV5_bYXWq-PySyPnPedfShG3M71250BW6fG7V9ZyaIL1sVIE-9_wIbc6WvHu1d9nk17R4snRoyDZiQDSNLmh84ls926hIn6s3VWAk4QG3-ODOpaMbQY2H05SubQK_BHohStp74uM3NXrOo3EOmbLZiCmFeVhovy4Ojm6yMN0q96n-luxUJuzVCj7fGwizg1sa1xgagTkEhMNZvu6gnJ1BhHfCOwciIP2VDegBWri8KsuDMZC6fhF1ZUQEeDjBhVZYgFv-ARNZcbBt4wgZiAA',
        ]);

        PriceList::create([
            'name' => 'Default',
            'instance_id' => '1',
            'description' => 'Default Price List Provider 1.',
            'provider_id' => '1',
        ]);

        PriceList::create([
            'name' => 'Default',
            'instance_id' => '1',
            'description' => 'Default Price List Provider 2.',
            'provider_id' => '2',
        ]);

    	$reseller = Reseller::create([
    		'company_name' => 'Reseller 1',
    		'address_1' => 'Address',
    		'address_2' => 'complment',
    		'country_id' => '724',
    		'provider_id' => $provider->id,
    		'state' => 'Madrid',
    		'city' => 'Madrid',
    		'nif' => '12345',
    		'postal_code' => '28000',
    		'status_id' => $active->id,
    	]);

        $subReseller = Reseller::create([
            'company_name' => 'Sub Reseller 1',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            'provider_id' => $provider->id,
            'main_office' => $reseller->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12345',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer1 = Customer::create([
            'company_name' => 'Customer 1',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12345',
            'postal_code' => '28000',
            'status_id' => $active->id,
            'markup' => '15',
        ]);

        $customer2 = Customer::create([
            'company_name' => 'Customer 2',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12346',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer3 = Customer::create([
            'company_name' => 'Customer 3',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12347',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer1->resellers()->attach($reseller);
        $customer2->resellers()->attach($reseller);
        $customer3->resellers()->attach($reseller);
        $subReseller->customers()->attach($customer3);


        $reseller2 = Reseller::create([
            'company_name' => 'Reseller 2',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            'provider_id' => $provider->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12345',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer4 = Customer::create([
            'company_name' => 'Customer 4',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller2->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12345',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer5 = Customer::create([
            'company_name' => 'Customer 5',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller2->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12346',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer6 = Customer::create([
            'company_name' => 'Customer 6',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller2->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12347',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer4->resellers()->attach($reseller2);
        $customer5->resellers()->attach($reseller2);
        $customer6->resellers()->attach($reseller2);


        $reseller3 = Reseller::create([
            'company_name' => 'Reseller 3',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            'provider_id' => $provider2->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12310',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer7 = Customer::create([
            'company_name' => 'Customer 7',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller3->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12345',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer8 = Customer::create([
            'company_name' => 'Customer 8',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller3->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12346',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer9 = Customer::create([
            'company_name' => 'Customer 9',
            'address_1' => 'Address',
            'address_2' => 'complment',
            'country_id' => '724',
            // 'reseller_id' => $reseller3->id,
            'state' => 'Madrid',
            'city' => 'Madrid',
            'nif' => '12347',
            'postal_code' => '28000',
            'status_id' => $active->id,
        ]);

        $customer7->resellers()->attach($reseller3);
        $customer8->resellers()->attach($reseller3);
        $customer9->resellers()->attach($reseller3);



        // $priceList1 = PriceList::find(1);
        // $priceList2 = PriceList::find(2);

        // $provider->availablePriceLists()->associate($priceList1);
        // $provider2->availablePriceLists()->associate($priceList2);

        // $provider->save();
        // $provider2->save();


        // foreach ($provider->resellers as $reseller) {
        //     $reseller->priceList()->associate($priceList1);
        //     $reseller->save();
        // }

        // foreach ($provider2->resellers as $reseller) {
        //     $reseller->priceList()->associate($priceList2);
        //     $reseller->save();
        // }
    }
}
