<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Discount;
use App\Models\Member;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
    }

    public function searchclient($ci)
    {
        $user = Customer::where('ci', $ci)->first();
        $products = Product::where('current_stock', '>', 0)->get();
        $discounts = Discount::where('start_date', '<=', now())->where('end_date', '>=', now())->where('for_members', '=', 0)->get();
        $role = 'client';
        $paymentMethods=PaymentType::get();
        $sale = Sale::firstOrCreate(
            [
                'customer_id' => $user->id, 
                'state' => 1
            ],
            [
                'user_id'          => Auth::id(),      
                'member_id'        => null,         
                'payment_type_id'  => null,             
                'discount_id'      => null,              
                'total_amount'     => 0.00,            
                'discount_payment' => 0.00,             
                'sale_date'        => Carbon::now()->toDateString(), 
            ]
        );
        $saleDetails = SaleDetail::with('product')
            ->where('sale_id', $sale->id)
             ->get();

        return view('sale.sale_form', compact('user', 'products', 'discounts', 'role','sale','saleDetails','paymentMethods'));
    }

    public function searchmember($ci)
    {
        $user = Member::where('ci', $ci)->first();
        $products = Product::where('current_stock', '>', 0)->get();
        $discounts = Discount::where('start_date', '<=', now())->where('end_date', '>=', now())->where('for_members', '=', 1)->get();
        $role = 'member';
        $paymentMethods=PaymentType::get();
        $sale = Sale::firstOrCreate(
            [
                'member_id' => $user->id, 
                'state' => 1
            ],
            [
                'user_id'          => Auth::id(),       
                'customer_id'        => null,              
                'payment_type_id'  => null,              
                'discount_id'      => null,               
                'total_amount'     => 0.00,            
                'discount_payment' => 0.00,              
                'sale_date'        => Carbon::now()->toDateString(), 
            ]
        );
        $saleDetails = SaleDetail::with('product')
            ->where('sale_id', $sale->id)
            ->get();
        return view('sale.sale_form', compact('user', 'products', 'discounts', 'role','sale','saleDetails','paymentMethods'));
    }

    public function additem(Request $request)
    {
        $validated = $request->validate([
            'sale_id'    => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:50',
        ]);

        
        $product = Product::findOrFail($validated['product_id']);

        if ($product->current_stock < $validated['quantity']) {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Stock Insuficiente')
                ->with('message', "Solo quedan {$product->current_stock} unidades disponibles de este producto.");
        }

        $priceSell = $product->price_sell;
        $quantity  = $validated['quantity'];
        $subtotal  = $priceSell * $quantity;

        SaleDetail::create([
            'sale_id'    => $validated['sale_id'],
            'product_id' => $validated['product_id'],
            'quantity'   => $quantity,
            'unit_price' => $priceSell,
            'subtotal'   => $subtotal,
        ]);

        $product->decrement('current_stock', $quantity);

        return redirect()->back();
    }

    public function removeitem($id)
    {
        $detail = SaleDetail::findOrFail($id);
        $product = Product::findOrFail($detail->product_id);
        $product->increment('current_stock', $detail->quantity);

        $sale = Sale::findOrFail($detail->sale_id);
        $sale->decrement('total_amount', $detail->subtotal);
        $detail->delete();

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Item Eliminado')
            ->with('message', 'El producto fue removido y el stock se restauró con éxito.');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'sale_id'          => 'required|exists:sales,id',
            'discount_id'      => 'nullable|exists:discounts,id',
            'payment_type_id'  => 'required|exists:payment_types,id',
            'subtotal'         => 'required|numeric|min:0',
            'discount_payment' => 'required|numeric|min:0',
            'total_amount'     => 'required|numeric|min:0',
        ], [
            'sale_id.required'          => 'El identificador de la venta es obligatorio.',
            'sale_id.exists'            => 'La venta seleccionada no es válida o no existe.',
            'discount_id.exists'        => 'El descuento seleccionado no es válido.',
            'payment_type_id.required'  => 'Debe seleccionar un método de pago para finalizar la venta.',
            'payment_type_id.exists'    => 'El método de pago seleccionado no es válido.',
            'subtotal.required'         => 'El subtotal es obligatorio.',
            'subtotal.numeric'          => 'El subtotal debe ser un valor numérico.',
            'subtotal.min'              => 'El subtotal no puede ser un número negativo.',
            'discount_payment.required' => 'El monto del descuento es obligatorio.',
            'discount_payment.numeric'  => 'El descuento debe ser un valor numérico.',
            'discount_payment.min'      => 'El descuento no puede ser un número negativo.',
            'total_amount.required'     => 'El monto total a pagar es obligatorio.',
            'total_amount.numeric'      => 'El total debe ser un valor numérico.',
            'total_amount.min'          => 'El total a pagar no puede ser un número negativo.',
        ]);

        $sale = Sale::findOrFail($validated['sale_id']);

        // 2. Actualizamos todos los campos requeridos
        $sale->update([
            'payment_type_id'  => $validated['payment_type_id'],
            'discount_id'      => $validated['discount_id'] ?? null, 
            'total_amount'     => $validated['subtotal'],
            'discount_payment' => $validated['discount_payment'],
            'state'            => false, 
        ]);

        return redirect()->route('home') 
            ->with('icon', 'success')
            ->with('title', '¡Venta Realizada!')
            ->with('message', "La venta #{$sale->id} ha sido procesada y registrada con éxito.");
        }
    
}
