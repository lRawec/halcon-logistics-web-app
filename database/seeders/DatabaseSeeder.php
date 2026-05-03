<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default Admin user
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'is_active' => true,
        ]);

        // Create test Sales user
        User::create([
            'username' => 'sales_user',
            'password' => Hash::make('sales123'),
            'role' => 'Sales',
            'is_active' => true,
        ]);

        // Create test Warehouse user
        User::create([
            'username' => 'warehouse_user',
            'password' => Hash::make('warehouse123'),
            'role' => 'Warehouse',
            'is_active' => true,
        ]);

        // Create test Route user
        User::create([
            'username' => 'route_user',
            'password' => Hash::make('route123'),
            'role' => 'Route',
            'is_active' => true,
        ]);
    }
}
