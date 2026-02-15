<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class CountryStateSeeder extends Seeder
{
    public function run(): void
    {
        $countries = json_decode(file_get_contents(database_path('data/countries.json')), true);
        $states = json_decode(file_get_contents(database_path('data/states.json')), true);

        // Clear old data (optional)
        State::truncate();
        Country::truncate();

        $batchSize = 50; // insert in batches of 50 to reduce memory usage

        // Insert countries in batches
        foreach (array_chunk($countries, $batchSize) as $chunk) {
            $data = [];
            foreach ($chunk as $c) {
                $data[] = [
                    'name' => $c['name'],
                    'iso_code' => $c['iso2'] ?? null,
                    'iso3' => $c['iso3'] ?? null,
                    'phone_code' => $c['phone_code'] ?? null,
                    'currency_code' => $c['currency_code'] ?? $c['currency'] ?? null,
                    'currency_name' => $c['currency_name'] ?? null,
                    'continent' => $c['region'] ?? null,
                    'flag' => $c['emoji'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Country::insert($data);
        }

        // Insert states in batches
        foreach (array_chunk($states, $batchSize) as $chunk) {
            $data = [];
            foreach ($chunk as $s) {
                // Find country by iso_code if country_id not directly provided
                $country = Country::where('iso_code', $s['country_code'])->first();
                if (!$country) continue;

                $data[] = [
                    'name' => $s['name'],
                    'country_id' => $country->id,
                    'country_code' => $s['country_code']??null,
                    'iso_code' => $s['code'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            State::insert($data);
        }
    }
}
