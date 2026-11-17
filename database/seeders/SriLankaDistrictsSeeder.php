<?php

namespace Database\Seeders;

use App\Domains\Platform\Models\Setting;
use Illuminate\Database\Seeder;

class SriLankaDistrictsSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            // Western Province
            ['id' => 'colombo', 'name' => 'Colombo', 'province' => 'Western'],
            ['id' => 'gampaha', 'name' => 'Gampaha', 'province' => 'Western'],
            ['id' => 'kalutara', 'name' => 'Kalutara', 'province' => 'Western'],

            // Central Province
            ['id' => 'kandy', 'name' => 'Kandy', 'province' => 'Central'],
            ['id' => 'matale', 'name' => 'Matale', 'province' => 'Central'],
            ['id' => 'nuwara_eliya', 'name' => 'Nuwara Eliya', 'province' => 'Central'],

            // Southern Province
            ['id' => 'galle', 'name' => 'Galle', 'province' => 'Southern'],
            ['id' => 'matara', 'name' => 'Matara', 'province' => 'Southern'],
            ['id' => 'hambantota', 'name' => 'Hambantota', 'province' => 'Southern'],

            // Northern Province
            ['id' => 'jaffna', 'name' => 'Jaffna', 'province' => 'Northern'],
            ['id' => 'kilinochchi', 'name' => 'Kilinochchi', 'province' => 'Northern'],
            ['id' => 'mannar', 'name' => 'Mannar', 'province' => 'Northern'],
            ['id' => 'vavuniya', 'name' => 'Vavuniya', 'province' => 'Northern'],
            ['id' => 'mullaitivu', 'name' => 'Mullaitivu', 'province' => 'Northern'],

            // Eastern Province
            ['id' => 'batticaloa', 'name' => 'Batticaloa', 'province' => 'Eastern'],
            ['id' => 'ampara', 'name' => 'Ampara', 'province' => 'Eastern'],
            ['id' => 'trincomalee', 'name' => 'Trincomalee', 'province' => 'Eastern'],

            // North Western Province
            ['id' => 'kurunegala', 'name' => 'Kurunegala', 'province' => 'North Western'],
            ['id' => 'puttalam', 'name' => 'Puttalam', 'province' => 'North Western'],

            // North Central Province
            ['id' => 'anuradhapura', 'name' => 'Anuradhapura', 'province' => 'North Central'],
            ['id' => 'polonnaruwa', 'name' => 'Polonnaruwa', 'province' => 'North Central'],

            // Uva Province
            ['id' => 'badulla', 'name' => 'Badulla', 'province' => 'Uva'],
            ['id' => 'monaragala', 'name' => 'Monaragala', 'province' => 'Uva'],

            // Sabaragamuwa Province
            ['id' => 'ratnapura', 'name' => 'Ratnapura', 'province' => 'Sabaragamuwa'],
            ['id' => 'kegalle', 'name' => 'Kegalle', 'province' => 'Sabaragamuwa'],
        ];

        Setting::set('sri_lanka_districts', $districts, 'geography', true);
    }
}
