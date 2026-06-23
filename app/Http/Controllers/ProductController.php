<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categorie;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->paginate(10);
        $categories = Categorie::all()->pluck('name', 'id');
        //return response()->json($products);
        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. \s]+$/',
            'description' => 'nullable|string|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ(). \s]+$/',
            'category_id' => 'required|exists:categories,id',
            'price_buy' => 'required|numeric|min:0',
            'price_sell' => 'required|numeric|min:0',
            'expiration_date' => 'required|date|after_or_equal:today',
            'min_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
            ], [
                'current_stock.integer' => 'El stock actual debe ser un número entero.',
                'current_stock.min' => 'El stock actual no puede ser negativo.',
                'current_stock.required' => 'El stock actual es obligatorio.',
                'name.required' => 'El nombre del producto es obligatorio.',
                'name.string' => 'El nombre del producto debe ser una cadena de texto.',
                'name.max' => 'El nombre del producto no puede exceder los 255 caracteres.',
                'name.regex' => 'El nombre del producto solo puede contener letras, números, espacios, puntos y caracteres acentuados.',
                'description.string' => 'La descripción del producto debe ser una cadena de texto.',
                'description.regex' => 'La descripción del producto solo puede contener letras, números, espacios, puntos, paréntesis y caracteres acentuados.',
                'category_id.required' => 'La categoría es obligatoria.',
                'category_id.exists' => 'La categoría seleccionada no es válida.',
                'price_buy.required' => 'El precio de compra es obligatorio.',
                'price_buy.numeric' => 'El precio de compra debe ser un número.',
                'price_buy.min' => 'El precio de compra no puede ser negativo.',
                'price_sell.required' => 'El precio de venta es obligatorio.',
                'price_sell.numeric' => 'El precio de venta debe ser un número.',
                'price_sell.min' => 'El precio de venta no puede ser negativo.',
                'expiration_date.required' => 'La fecha de vencimiento es obligatoria.',
                'expiration_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
                'expiration_date.after_or_equal' => 'La fecha de vencimiento no puede ser anterior a hoy.',
                'min_stock.required' => 'El stock mínimo es obligatorio.',
                'min_stock.integer' => 'El stock mínimo debe ser un número entero.',
                'min_stock.min' => 'El stock mínimo no puede ser negativo.',
            ]);

        Product::create($request->all());

        return redirect()->route('products')->with('icon', 'success')->with('message', 'Producto creado exitosamente.')->with('title', '¡Éxito!');
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. \s]+$/',
            'description' => 'nullable|string|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ(). \s]+$/',
            'category_id' => 'required|exists:categories,id',
            'price_buy' => 'required|numeric|min:0',
            'price_sell' => 'required|numeric|min:0',
            'expiration_date' => 'required|date',
            'min_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
        ], [
            'current_stock.integer' => 'El stock actual debe ser un número entero.',
            'current_stock.min' => 'El stock actual no puede ser negativo.',
            'current_stock.required' => 'El stock actual es obligatorio.',
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.string' => 'El nombre del producto debe ser una cadena de texto.',
            'name.max' => 'El nombre del producto no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre del producto solo puede contener letras, números, espacios, puntos y caracteres acentuados.',
            'description.string' => 'La descripción del producto debe ser una cadena de texto.',
            'description.regex' => 'La descripción del producto solo puede contener letras, números, espacios, puntos, paréntesis y caracteres acentuados.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'price_buy.required' => 'El precio de compra es obligatorio.',
            'price_buy.numeric' => 'El precio de compra debe ser un número.',
            'price_buy.min' => 'El precio de compra no puede ser negativo.',
            'price_sell.required' => 'El precio de venta es obligatorio.',
            'price_sell.numeric' => 'El precio de venta debe ser un número.',
            'price_sell.min' => 'El precio de venta no puede ser negativo.',
            'expiration_date.required' => 'La fecha de vencimiento es obligatoria.',
            'expiration_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'min_stock.required' => 'El stock mínimo es obligatorio.',
            'min_stock.integer' => 'El stock mínimo debe ser un número entero.',
            'min_stock.min' => 'El stock mínimo no puede ser negativo.',
        ]);

        $product->update($request->all());

        return redirect()->route('products')->with('icon', 'success')->with('message', 'Producto actualizado exitosamente.')->with('title', '¡Éxito!');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products')->with('icon', 'success')->with('message', 'Producto eliminado exitosamente.')->with('title', '¡Éxito!');
    }
}
