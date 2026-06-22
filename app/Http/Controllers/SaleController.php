<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Discount;
use App\Models\Member;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return view('sale.sale');
    }

    public function searchmembers(Request $request)
    {
        $request->validate([
            'member' => 'required|regex:/^[0-9]+$/|min:7|max:10|exists:members,ci',
        ], [
            'member.required' => 'El CI es obligatorio.',
            'member.regex' => 'El CI debe contener solo números.',
            'member.min' => 'El CI debe tener al menos 7 caracteres.',
            'member.max' => 'El CI no debe tener más de 10 caracteres.',
            'member.exists' => 'El usuario no está registrado en el sistema.',
        ]);
        $ci = $request->member;

        return redirect()->route('search.member', ['ci' => $ci]);
        // return response()->json($request);
    }

    public function searchclients(Request $request)
    {
        $request->validate([
            'client' => 'required|regex:/^[0-9]+$/|min:7|max:10|exists:customers,ci',
        ], [
            'client.required' => 'El CI es obligatorio.',
            'client.regex' => 'El CI debe contener solo números.',
            'client.min' => 'El CI debe tener al menos 7 caracteres.',
            'client.max' => 'El CI no debe tener más de 10 caracteres.',
            'client.exists' => 'El usuario no está registrado en el sistema.',
        ]);
        $ci = $request->client;

        return redirect()->route('search.client', ['ci' => $ci]);
        // return response()->json($request);
    }

    public function searchclient($ci)
    {
        $user = Customer::where('ci', $ci)->first();
        $products = Product::where('current_stock', '>', 0)->get();
        $discounts = Discount::where('start_date', '<=', now())->where('end_date', '>=', now())->where('for_members', '=', 0)->get();
        $role = 'client';

        return view('sale.sale_form', compact('user', 'products', 'discounts', 'role'));
        // return response()->json($client);
    }

    public function searchmember($ci)
    {
        $user = Member::where('ci', $ci)->first();
        $products = Product::where('current_stock', '>', 0)->get();
        $discounts = Discount::where('start_date', '<=', now())->where('end_date', '>=', now())->where('for_members', '=', 1)->get();
        $role = 'member';

        return view('sale.sale_form', compact('user', 'products', 'discounts', 'role'));
        // return response()->json($member);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'discount_id' => 'nullable|integer|exists:discounts,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ], [
            'user_id.required' => 'El cliente es obligatorio.',
            'products.required' => 'Debe agregar al menos un producto.',
            'products.min' => 'Debe agregar al menos un producto.',
        ]);

        $subtotal = 0;
        $products = [];

        // Validar stock y calcular subtotal
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $quantity = $productData['quantity'];

            if ($product->current_stock < $quantity) {
                return back()->withErrors(['stock' => "Stock insuficiente para {$product->name}. Disponible: {$product->current_stock}"]);
            }

            $subtotal += $product->price_sell * $quantity;
            $products[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => $product->price_sell,
                'subtotal' => $product->price_sell * $quantity,
            ];
        }

        // Calcular descuento
        $discountAmount = 0;
        if ($request->discount_id) {
            $discount = Discount::findOrFail($request->discount_id);
            $discountAmount = $subtotal * ($discount->percentage / 100);
        }

        $total = $subtotal - $discountAmount;

        // Determinar si es cliente o miembro
        $customerId = null;
        $memberId = null;
        $role = $request->input('user_role');

        if ($role === 'member') {
            $memberId = $request->user_id;
        } else {
            $customerId = $request->user_id;
        }

        // Crear venta
        $sale = Sale::create([
            'customer_id' => $customerId,
            'member_id' => $memberId,
            'discount_id' => $request->discount_id,
            'user_id' => auth()->id(),
            'payment_type_id' => 1, // Default
            'total_amount' => $total,
            'discount_payment' => $discountAmount,
            'sale_date' => now()->toDateString(),
        ]);

        // Crear detalles de venta y actualizar stock
        foreach ($products as $item) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);

            // Actualizar stock
            $item['product']->decrement('current_stock', $item['quantity']);
        }

        return redirect()->route('sale')->with('success', 'Venta realizada exitosamente.');
    }
}
