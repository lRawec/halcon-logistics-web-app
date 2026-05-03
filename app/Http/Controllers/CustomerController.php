<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_number' => 'required|unique:customers,customer_number|numeric',
            'name' => 'required|string|max:255',
            'fiscal_data' => 'required|string',
            'delivery_address' => 'required|string',
        ]);

        Customer::create([
            'customer_number' => $request->customer_number,
            'name' => $request->name,
            'fiscal_data' => $request->fiscal_data,
            'delivery_address' => $request->delivery_address,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }
}
