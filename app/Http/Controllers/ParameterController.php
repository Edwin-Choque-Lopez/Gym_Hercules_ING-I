<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\PaymentType;

class ParameterController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        $paymentTypes = PaymentType::paginate(5);
        return view('parameters.index', compact('roles', 'paymentTypes'));
    }
    public function paymenttypestore(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|unique:payment_types|string|max:255|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ() \s]+$/', // Solo letras, números y espacios
        ],
        [
            'name.unique' => 'El nombre del método de pago ya existe.',
            'name.required' => 'El nombre del método de pago es obligatorio.',
            'name.string' => 'El nombre del método de pago debe ser una cadena de texto.',
            'name.max' => 'El nombre del método de pago no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre del método de pago solo puede contener letras, números, espacios y paréntesis.',
        ]);

        // Crear un nuevo método de pago
        $paymentType = new PaymentType();
        $paymentType->name = $request->input('name');
        $paymentType->save();

        return redirect()->route('parameters')->with('icon', 'success')->with('title', 'Método de pago creado')->with('message', 'Los datos del método de pago se han guardado exitosamente.');
    }
    public function paymenttypeupdate(Request $request, $id)
    {
        $paymentType = PaymentType::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|unique:payment_types,name,' . $paymentType->id . '|string|max:255|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ() \s]+$/', // Solo letras, números y espacios
        ],
        [
            'name.required' => 'El nombre del método de pago es obligatorio.',
            'name.string' => 'El nombre del método de pago debe ser una cadena de texto.',
            'name.max' => 'El nombre del método de pago no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre del método de pago solo puede contener letras, números, espacios y paréntesis.',
        ]);

        // Actualizar el método de pago
        $paymentType->name = $request->input('name');
        $paymentType->save();

        return redirect()->route('parameters')->with('icon', 'success')->with('title', 'Método de pago actualizado')->with('message', 'Los datos del método de pago se han actualizado exitosamente.');
    }
    public function paymenttypedestroy($id){
        $paymentType = PaymentType::findOrFail($id);
        $paymentType->delete();

        return redirect()->route('parameters')->with('icon', 'success')->with('title', 'Método de pago eliminado')->with('message', 'El método de pago se ha eliminado exitosamente.');
    }
}
