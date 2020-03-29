<?php

use App\Customer;
use App\Provider;
use App\Reseller;
use App\Status;
use Illuminate\Database\Seeder;

class CreateProviderResellerCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $active = Status::where('name', 'message.active')->first();

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

        
    }
}
