<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Unit Coordinator',
                'email' => 'unit.coordinator@gmail.com',
                'role' => 'unit_coordinator',
            ],
            [
                'name' => 'Quality Coordinator',
                'email' => 'quality.coordinator@gmail.com',
                'role' => 'quality_coordinator',
            ],
            [
                'name' => 'Risk Management Coordinator',
                'email' => 'risk.management.coordinator@gmail.com',
                'role' => 'risk_management_coordinator',
            ],
            [
                'name' => 'Health Center Head',
                'email' => 'health.center.head@gmail.com',
                'role' => 'health_center_head',
            ],
            [
                'name' => 'Health Department',
                'email' => 'health.department@gmail.com',
                'role' => 'health_department',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'role' => $u['role'],
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
