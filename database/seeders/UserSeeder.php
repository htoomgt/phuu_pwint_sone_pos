<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'full_name' => 'Htoo Maung Thait',
            'username' => 'htoo htoo',
            'password' => Hash::make('developerPwds09#'),
        ]);

        $user->assignRole('super-admin');
    }
}
