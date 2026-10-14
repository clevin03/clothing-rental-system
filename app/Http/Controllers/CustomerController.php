<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Component 2: Directory & Search Interface
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('nic', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        return view('customers.create');
    }

    // Component 3: Registration with Validation & Duplicate Prevention
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'nic' => 'required|string|max:50|unique:customers,nic',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer registered successfully.');
    }

    // Component 4: Historical Profile Integration
    public function show(Customer $customer)
    {
        $customer->load('bookings'); // Loads related rental transactions
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'nic' => 'required|string|max:50|unique:customers,nic,' . $customer->id,
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}