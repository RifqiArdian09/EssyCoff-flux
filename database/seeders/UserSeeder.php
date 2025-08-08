<?php

// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@coffeeshop.com',
            'password' => Hash::make('password'),
        ]);
    }
}