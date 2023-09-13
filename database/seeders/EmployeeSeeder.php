<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::factory()->create(
            [
                'username' => 'employee',
                'email' => 'employee@example.com',
                'phone_number' => '0123456789',
            ]
        );
    }
}
