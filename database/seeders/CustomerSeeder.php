<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'customer_number' => 1001,
            'name' => 'Constructora Alfa',
            'fiscal_data' => 'RFC: CALF123456789',
            'delivery_address' => '123 Main St, Building Zone'
        ]);

        Customer::create([
            'customer_number' => 1002,
            'name' => 'Materiales del Norte',
            'fiscal_data' => 'RFC: MNOR987654321',
            'delivery_address' => '456 North Ave, Warehouse District'
        ]);
    }
}
