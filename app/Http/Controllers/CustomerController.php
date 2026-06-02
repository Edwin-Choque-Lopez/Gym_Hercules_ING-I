<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10); 
        return view('users.customer_index',compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|unique:customers,ci,regex:/^[0-9]+$/|min:7|max:10',
            'name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ \s]+$/',
        ],[
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios',   
            'ci.unique' => 'El CI ya está registrado.',
            'ci.regex' => 'El CI debe contener solo números.',
            'ci.min' => 'El CI debe tener al menos 7 caracteres.',
            'ci.max' => 'El CI no debe tener más de 10 caracteres.',
        ]);
        $customer = new Customer();
        $customer->ci = $request->ci;
        $customer->full_name = $request->name;
        if ($customer->save()){
            return redirect()->route('customers')->with('icon', 'success')->with('title', 'Cliente creado')->with('message', 'El cliente se ha creado exitosamente.');
        }else{
            return redirect()->route('customers')->with('icon','error')->with('title','Error')->with('message','Ocurrió un error al registrar al cliente, por favor intente nuevmanete');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ci' => 'required|regex:/^[0-9]+$/|min:7|max:10|unique:customers,ci,'.$id,
            'name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ \s]+$/',
        ],[
            'ci.required' => 'El CI es obligatorio.',
            'ci.regex' => 'El CI debe contener solo números.',
            'ci.min' => 'El CI debe tener al menos 7 caracteres.',
            'ci.max' => 'El CI no debe tener más de 10 caracteres.',
            'ci.unique' => 'El CI ya está registrado.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios',   
        ]);
        $customer = Customer::findOrFail($id);
        $customer->ci = $request->ci;
        $customer->full_name = $request->name;
        $customer->save();
        return redirect()->route('customers')->with('icon', 'success')->with('title', 'Cliente actualizado')->with('message', 'El cliente se ha actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers')->with('icon', 'success')->with('title', 'Cliente eliminado')->with('message', 'El cliente se ha eliminado exitosamente.');
    }
}
