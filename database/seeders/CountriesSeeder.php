<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Countries;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $table = Config::get('countries.table_name', 'countries');

        // Disable foreign key checks (MariaDB/MySQL)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($table)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $countries = Countries::getList();

        foreach ($countries as $countryId => $country) {
            DB::table($table)->insert([
                'id' => $countryId,
                'capital' => $country['capital'] ?? null,
                'citizenship' => $country['citizenship'] ?? null,
                'country_code' => $country['country-code'] ?? null,
                'currency' => $country['currency'] ?? null,
                'currency_code' => $country['currency_code'] ?? null,
                'currency_sub_unit' => $country['currency_sub_unit'] ?? null,
                'currency_decimals' => $country['currency_decimals'] ?? null,
                'full_name' => $country['full_name'] ?? null,
                'iso_3166_2' => $country['iso_3166_2'] ?? null,
                'iso_3166_3' => $country['iso_3166_3'] ?? null,
                'name' => $country['name'] ?? null,
                'region_code' => $country['region-code'] ?? null,
                'sub_region_code' => $country['sub-region-code'] ?? null,
                'eea' => (bool)($country['eea'] ?? false),
                'calling_code' => $country['calling_code'] ?? null,
                'currency_symbol' => $country['currency_symbol'] ?? null,
                'flag' => $country['flag'] ?? null,
            ]);
        }
    }
}
