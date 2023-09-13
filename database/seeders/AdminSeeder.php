<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::factory()->create(
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'phone_number' => '0123456789',
            ]
        );
    }
}
