<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'           => 'Super Admin',
            'email'          => 'admin@test.com',
            'password'       => Hash::make('admin1234'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name'           => 'Udin',
            'email'          => 'udin@test.com',
            'password'       => Hash::make('user1234'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
        $user->assignRole('user');
    }
}
