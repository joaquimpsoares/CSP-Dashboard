<?php

use App\Instance;
use Illuminate\Database\Seeder;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
