<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Lista general de órdenes 
    public function index()
    {
        $orders = Order::with(['customer', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('orders.index', compact('orders'));
    }

    // Crear orden
    public function create()
    {
        $customers = Customer::all();
        return view('orders.create', compact('customers'));
    }

    // Guardar la nueva orden
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|integer|unique:orders',
            'customer_number' => 'required|exists:customers,customer_number',
            'notes' => 'nullable|string',
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'customer_number' => $request->customer_number,
            'invoice_number' => $request->invoice_number,
            'order_date_time' => now(),
            'notes' => $request->notes,
            'status' => 'Ordered'
        ]);

        return redirect()->route('orders.index');
    }

    // Ver detalles de la orden
    public function show(Order $order)
    {
        // Evidencias fotográficas junto con la orden
        $order->load('photoEvidences', 'customer', 'user');
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Ordered,InProcess,InRoute,Delivered',
            'photo' => 'nullable|image|max:2048'
        ]);

        $order->status = $request->status;
        $order->save();

        if ($request->hasFile('photo') && in_array($request->status, ['InRoute', 'Delivered'])) {
            $path = $request->file('photo')->store('public/evidences');

            \App\Models\PhotoEvidence::create([
                'order_id' => $order->order_id,
                'file_path' => str_replace('public/', 'storage/', $path),
                'upload_date' => now(),
                'type' => ($request->status == 'InRoute' ? 'Loaded' : 'Delivered')
            ]);
        }

        return redirect()->route('orders.show', $order->order_id);
    }

    // Borrado Lógico (Mover a la papelera)
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }

    // Lista de órdenes archivadas (Papelera)
    public function archived()
    {
        $orders = Order::onlyTrashed()->with('customer')->get();
        return view('orders.archived', compact('orders'));
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->where('order_id', $id)->firstOrFail();
        $order->restore();
        return redirect()->route('orders.archived');
    }
}
