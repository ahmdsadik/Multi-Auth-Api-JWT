<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(
            [
                'username' => 'user',
                'email' => 'user@example.com',
                'phone_number' => '0123456789',
            ]
        );
    }
}
