<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'forumadmin@yopmail.com'],
            [
                'name' => 'Forum Admin',
                'password' => Hash::make('Admin@1234'),
                'role' => 'admin',
                'email_verified_at' => now(),

            ]
        );
    }
}
