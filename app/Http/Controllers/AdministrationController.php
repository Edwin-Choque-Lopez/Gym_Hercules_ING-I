<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class AdministrationController extends Controller
{
    public function index()
    {
        $categories = Categorie::paginate(5);
        return view('administration.index', compact('categories'));
    }
    public function categorystore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ. \s]+$/',
            'description' => 'nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ()., \s]+$/',
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
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . '|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ. \s]+$/',
            'description' => 'nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ()., \s]+$/',
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
}
