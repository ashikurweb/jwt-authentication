<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'name' => 'Ashikur Rahman',
            'username' => 'ashikurweb',
            'email' => 'ashikurrahman7194@gmail.com',
            'phone' => '+8801700917194',
            'password' => Hash::make('11111111'),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);

        $admin->assignRole('super-admin');
    }
}
