<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemSetting::create([
            'setting_name' => 'currency',
            'setting_value' => 'mmk'
        ]);

        SystemSetting::create([
            'setting_name' => 'store_name',
            'setting_value' => 'Phu Pwint Sone Grocery'
        ]);

        SystemSetting::create([
            'setting_name' => 'store_address',
            'setting_value' => 'No.164, King Min Bar Road, Rakhine State, Myanmar'
        ]);

        SystemSetting::create([
            'setting_name' => 'store_phone',
            'setting_value' => '(+95)9793432709'
        ]);

        SystemSetting::create([
            'setting_name' => 'store_email',
            'setting_value' => 'sms.akyab@gmail.com'
        ]);

        SystemSetting::create([
            'setting_name' => 'store_website',
            'setting_value' => ''
        ]);

        SystemSetting::create([
            'setting_name' => 'tax_percentage',
            'setting_value' => '0.00'
        ]);

        SystemSetting::create([
            'setting_name' => 'dashboard_date_range',
            'setting_value' => '1 month'
        ]);
    }
}
