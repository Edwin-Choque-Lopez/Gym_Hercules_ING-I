<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Discount;

class AdministrationController extends Controller
{
    public function index()
    {
        $discounts = Discount::paginate(5);
        $categories = Categorie::paginate(5);
        return view('administration.index', compact('categories', 'discounts'));
    }
    public function categorystore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ. \s]+$/',
            'description' => 'nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ0-9()., \s]+$/',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
            'name.unique' => 'El nombre de la categoría ya existe.',
            'name.regex' => 'El campo nombre solo puede contener letras, espacios y puntos.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
            'description.max' => 'El campo descripción no debe exceder los 255 caracteres.',
            'description.regex' => 'El campo descripción solo puede contener letras, espacios, puntos y comas.',
        ]);
        Categorie::create($request->all());
        return redirect()->route('administration')->with('icon', 'success')->with('title', 'Categoría creada')->with('message', 'Los datos de la categoría se han guardado exitosamente.');
    }

    public function categoryupdate(Request $request, $id)
    {
        $category = Categorie::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . '|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ. \s]+$/',
            'description' => 'nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ0-9()., \s]+$/',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
            'name.unique' => 'El nombre de la categoría ya existe.',
            'name.regex' => 'El campo nombre solo puede contener letras, espacios y puntos.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
            'description.max' => 'El campo descripción no debe exceder los 255 caracteres.',
            'description.regex' => 'El campo descripción solo puede contener letras, espacios, puntos y comas.',
        ]);
        $category->update($request->only('name', 'description'));

        return redirect()->route('administration')->with('icon', 'success')->with('title', 'Categoría actualizada')->with('message', 'los datos de la categoría se han actualizado exitosamente.');
    }
    public function categorydestroy($id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();
        return redirect()->route('administration')->with('icon', 'success')->with('title', 'Categoría eliminada')->with('message', 'Los datos de la categoría se han eliminado exitosamente.');
    }

    public function discountstore(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255|unique:discounts,name|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ. \s]+$/',
            'description' => 'nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ0-9()., \s]+$/',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
            'name.unique' => 'El nombre del descuento ya existe.',
            'name.regex' => 'El campo nombre solo puede contener letras, espacios y puntos.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
            'description.max' => 'El campo descripción no debe exceder los 255 caracteres.',
            'description.regex' => 'El campo descripción solo puede contener letras, espacios, puntos y comas.',
            'percentage.required' => 'El campo porcentaje es obligatorio.',
            'percentage.numeric' => 'El campo porcentaje debe ser un número.',
            'percentage.min' => 'El campo porcentaje no puede ser menor que 0.',
            'percentage.max' => 'El campo porcentaje no puede ser mayor que 100.',
            'start_date.required' => 'El campo fecha de inicio es obligatorio.',
            'start_date.date' => 'El campo fecha de inicio debe ser una fecha válida.',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a la fecha actual.',
            'end_date.required' => 'El campo fecha de fin es obligatorio.',
            'end_date.date' => 'El campo fecha de fin debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ]);
        $data = $request->all();
        $data['percentage'] = $request->percentage / 100;
        Discount::create($data);
        return redirect()->route('administration')->with('icon', 'success')->with('title', 'Descuento creado')->with('message', 'Los datos del descuento se han guardado exitosamente.');
    }   
    public function discountupdate(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:discounts,name,' . $discount->id . '|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ. \s]+$/',
            'description' => 'nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñ0-9()., \s]+$/',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
            'name.unique' => 'El nombre del descuento ya existe.',
            'name.regex' => 'El campo nombre solo puede contener letras, espacios y puntos.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
            'description.max' => 'El campo descripción no debe exceder los 255 caracteres.',
            'description.regex' => 'El campo descripción solo puede contener letras, espacios, puntos y comas.',
            'percentage.required' => 'El campo porcentaje es obligatorio.',
            'percentage.numeric' => 'El campo porcentaje debe ser un número.',
            'percentage.min' => 'El campo porcentaje no puede ser menor que 0.',
            'percentage.max' => 'El campo porcentaje no puede ser mayor que 100.',
            'start_date.required' => 'El campo fecha de inicio es obligatorio.',
            'start_date.date' => 'El campo fecha de inicio debe ser una fecha válida.',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a la fecha actual.',
            'end_date.required' => 'El campo fecha de fin es obligatorio.',
            'end_date.date' => 'El campo fecha de fin debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ]);
        $data = $request->all();
        $data['percentage'] = $request->percentage / 100;
        $discount->update($data);
        return redirect()->route('administration')->with('icon', 'success')->with('title', 'Descuento actualizado')->with('message', 'Los datos del descuento se han actualizado exitosamente.');
    }
    public function discountdestroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return redirect()->route('administration')->with('icon', 'success')->with('title', 'Descuento eliminado')->with('message', 'Los datos del descuento se han eliminado exitosamente.');
    }
}