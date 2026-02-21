<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;

class CountryStateSeeder extends Seeder
{
    // php artisan db:seed --class=CountryStateSeeder
    
    public function run(): void
    {
        $driver = DB::connection()->getDriverName();

        /*
        |--------------------------------------------------------------------------
        | Safe Truncate (MySQL & PostgreSQL Compatible)
        |--------------------------------------------------------------------------
        */

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            State::truncate();
            Country::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'pgsql') {
            DB::statement('TRUNCATE TABLE states RESTART IDENTITY CASCADE;');
            DB::statement('TRUNCATE TABLE countries RESTART IDENTITY CASCADE;');
        } else {
            State::truncate();
            Country::truncate();
        }

        /*
        |--------------------------------------------------------------------------
        | Load JSON Files
        |--------------------------------------------------------------------------
        */

        $countries = json_decode(
            file_get_contents(database_path('data/countries.json')),
            true
        );

        $states = json_decode(
            file_get_contents(database_path('data/states.json')),
            true
        );

        $batchSize = 1000;
        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Insert Countries
        |--------------------------------------------------------------------------
        */

        foreach (array_chunk($countries, $batchSize) as $chunk) {
            $insertData = [];

            foreach ($chunk as $c) {
                $insertData[] = [
                    'name' => $c['name'] ?? null,
                    'iso_code' => strtoupper($c['iso2'] ?? ''),
                    'iso3' => $c['iso3'] ?? null,
                    'phone_code' => $c['phone_code'] ?? null,
                    'currency_code' => $c['currency_code'] ?? $c['currency'] ?? null,
                    'currency_name' => $c['currency_name'] ?? null,
                    'continent' => $c['region'] ?? null,
                    'flag' => $c['emoji'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            Country::insert($insertData);
        }

        /*
        |--------------------------------------------------------------------------
        | Build Country ISO Map (Single Query)
        |--------------------------------------------------------------------------
        */

        $countryMap = Country::pluck('id', 'iso_code')->toArray();

        /*
        |--------------------------------------------------------------------------
        | Insert States
        |--------------------------------------------------------------------------
        */

        foreach (array_chunk($states, $batchSize) as $chunk) {
            $insertData = [];

            foreach ($chunk as $s) {
                $countryCode = strtoupper($s['country_code'] ?? '');

                if (!$countryCode || !isset($countryMap[$countryCode])) {
                    continue;
                }

                $insertData[] = [
                    'name' => $s['name'] ?? null,
                    'country_id' => $countryMap[$countryCode],
                    'country_code' => $countryCode,
                    'iso_code' => $s['code'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (!empty($insertData)) {
                State::insert($insertData);
            }
        }

        $this->command->info("Seeding completed for driver: {$driver}");
    }
}