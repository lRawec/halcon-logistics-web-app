<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\PhotoEvidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'user']);

        if ($request->filled('invoice')) {
            $query->where('invoice_number', 'like', '%' . $request->invoice . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer_number', 'like', '%' . $request->customer . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('order_date_time', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();

        $customersJson = $customers->map(function ($c) {
            return [
                'customer_number' => $c->customer_number,
                'name' => $c->name,
                'fiscal_data' => $c->fiscal_data,
                'delivery_address' => $c->delivery_address,
            ];
        })->toJson();

        return view('orders.create', compact('customers', 'customersJson'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|integer|unique:orders',
            'customer_number' => 'required|exists:customers,customer_number',
            'delivery_address' => 'required|string',
            'fiscal_data' => 'nullable|string',
            'order_date_time' => 'required|date_format:Y-m-d\TH:i',
            'notes' => 'nullable|string',
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'customer_number' => $request->customer_number,
            'invoice_number' => $request->invoice_number,
            'delivery_address' => $request->delivery_address,
            'order_date_time' => $request->order_date_time,
            'notes' => $request->notes,
            'status' => 'Ordered'
        ]);

        return redirect()->route('orders.index')
            ->with('success', "Order #" . $request->invoice_number . " created successfully!");
    }

    public function show(Order $order)
    {
        $order->load('photoEvidences', 'customer', 'user');
        return view('orders.show', compact('order'));
    }

    // Editar detalles de la orden (para editar form data)
    public function edit(Order $order)
    {
        $order->load('customer', 'user');
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'customers'));
    }

    // Actualizar estado de la orden
    public function update(Request $request, Order $order)
    {
        $userRole = strtolower(Auth::user()->role);

        // Validación del estado según rol
        $request->validate([
            'status' => 'nullable|in:Ordered,InProcess,InRoute,Delivered',
            'delivery_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo_in_route' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
            'photo_delivered' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
        ]);

        // Update order details
        if ($request->filled('delivery_address')) {
            $order->delivery_address = $request->delivery_address;
        }
        if ($request->filled('notes')) {
            $order->notes = $request->notes;
        }

        // Update status based on role permissions
        if ($request->filled('status')) {
            $newStatus = $request->status;

            // Admin can do anything
            if ($userRole === 'admin') {
                $order->status = $newStatus;
            }
            // Warehouse can move from Ordered to InProcess or InRoute
            elseif ($userRole === 'warehouse') {
                if (in_array($newStatus, ['InProcess', 'InRoute'])) {
                    $order->status = $newStatus;
                } else {
                    return redirect()->back()
                        ->with('error', 'Warehouse can only update to "In Process" or "In Route" status.');
                }
            }
            // Route can move from InRoute to Delivered
            elseif ($userRole === 'route') {
                if ($newStatus === 'Delivered' && $order->status === 'InRoute') {
                    $order->status = $newStatus;
                } else {
                    return redirect()->back()
                        ->with('error', 'Route can only mark as "Delivered" when status is "In Route".');
                }
            }
            // Sales can only change certain statuses
            elseif ($userRole === 'sales') {
                if (in_array($newStatus, ['Ordered', 'InProcess'])) {
                    $order->status = $newStatus;
                } else {
                    return redirect()->back()
                        ->with('error', 'Sales can only update to "Ordered" or "In Process" status.');
                }
            }
        }

        // Handle photo uploads for Route role
        if ($userRole === 'route' || $userRole === 'admin') {
            $newStatus = $request->filled('status') ? $request->status : null;
            $photoUploaded = false;
            
            // Upload photo when status is "In route" (loading photo)
            if ($request->hasFile('photo_in_route') && ($order->status === 'InRoute' || $newStatus === 'InRoute')) {
                $path = $request->file('photo_in_route')->store('evidences', 'public');
                
                // Remove old "Loaded" photo if exists
                PhotoEvidence::where('order_id', $order->order_id)
                    ->where('type', 'Loaded')
                    ->delete();

                PhotoEvidence::create([
                    'order_id' => $order->order_id,
                    'file_path' => 'storage/' . $path,
                    'upload_date' => now(),
                    'type' => 'Loaded'
                ]);
                $photoUploaded = true;
            }

            // Upload photo when status is "Delivered" (delivery photo)
            if ($request->hasFile('photo_delivered') && ($order->status === 'Delivered' || $newStatus === 'Delivered')) {
                $path = $request->file('photo_delivered')->store('evidences', 'public');

                // Remove old "Delivered" photo if exists
                PhotoEvidence::where('order_id', $order->order_id)
                    ->where('type', 'Delivered')
                    ->delete();

                PhotoEvidence::create([
                    'order_id' => $order->order_id,
                    'file_path' => 'storage/' . $path,
                    'upload_date' => now(),
                    'type' => 'Delivered'
                ]);
                $photoUploaded = true;
            }
        }

        $order->save();

        $message = 'Order updated successfully!';
        if ($request->filled('status')) {
            $message = "Order status changed to {$order->status}!";
            if ($request->hasFile('photo_in_route') || $request->hasFile('photo_delivered')) {
                $message .= " Photo evidence uploaded.";
            }
        } elseif ($request->filled('delivery_address') || $request->filled('notes')) {
            $message = 'Order details updated successfully!';
        }

        return redirect()->route('orders.show', $order->order_id)
            ->with('success', $message);
    }

    // Borrado Lógico (Mover a la papelera)
    public function destroy(Order $order)
    {
        $invoiceNumber = $order->invoice_number;
        $order->delete();
        
        return redirect()->route('orders.index')
            ->with('success', "Order #$invoiceNumber has been archived successfully.");
    }

    // Lista de órdenes archivadas (Papelera)
    public function archived(Request $request)
    {
        $query = Order::onlyTrashed()->with(['customer', 'user']);

        // Search by Invoice Number in archived
        if ($request->filled('invoice')) {
            $query->where('invoice_number', 'like', '%' . $request->invoice . '%');
        }

        // Search by Customer Number in archived
        if ($request->filled('customer')) {
            $query->where('customer_number', 'like', '%' . $request->customer . '%');
        }

        $orders = $query->orderBy('deleted_at', 'desc')->paginate(15);
        
        return view('orders.archived', compact('orders'));
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail((int)$id);
        $invoiceNumber = $order->invoice_number;
        $order->restore();
        
        return redirect()->route('orders.archived')
            ->with('success', "Order #$invoiceNumber has been restored successfully.");
    }
}
