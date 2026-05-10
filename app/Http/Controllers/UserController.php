<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios de la base de datos con su rol
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.name as role_name')
                ->paginate(5); // Agregar paginación
        $roles = Role::all()->pluck('name', 'id'); // Obtener los roles para el formulario de creación/edición
        //return response()->json($users);
        return view('users.user_index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ \s]+$/',
            'ci' => 'required|string|min:7|max:10|unique:users|regex:/^[0-9]+$/',
            'phone' => 'required|string|min:8|max:10|unique:users|regex:/^[0-9]+$/',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ], [
            'ci.required' => 'La cédula de identidad es obligatoria.',
            'ci.string' => 'La cédula de identidad debe ser una cadena de texto.',
            'ci.min' => 'La cédula de identidad debe tener al menos 7 caracteres.',
            'ci.max' => 'La cédula de identidad no puede exceder los 10 caracteres.',
            'ci.unique' => 'La cédula de identidad ya está en uso.',
            'ci.regex' => 'La cédula de identidad solo puede contener números.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.string' => 'El teléfono debe ser una cadena de texto.',
            'phone.min' => 'El teléfono debe tener al menos 8 caracteres.',
            'phone.max' => 'El teléfono no puede exceder los 10 caracteres.',
            'phone.unique' => 'El teléfono ya está en uso.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.regex' => 'El correo electrónico no tiene un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' =>'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'role_id.required' => 'El rol es obligatorio.',
            'role_id.exists' => 'El rol seleccionado no es válido.',
        ]);
        
        $user = new User();
        $user->name = $request->input('name');
        $user->ci = $request->input('ci');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role_id = $request->input('role_id');
        $user->save();
        return redirect()->route('users')->with('icon', 'success')->with('title', 'Usuario creado')->with('message', 'Los datos del usuario se han guardado exitosamente.');
        //return response()->json($request->all());
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ \s]+$/',
            'ci' => 'required|string|min:7|max:10|unique:users,ci,' . $id . '|regex:/^[0-9]+$/',
            'phone' => 'required|string|min:8|max:10|unique:users,phone,' . $id . '|regex:/^[0-9]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . '|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'role_id' => 'required|exists:roles,id',
        ], [
            'ci.required' => 'La cédula de identidad es obligatoria.',
            'ci.string' => 'La cédula de identidad debe ser una cadena de texto.',
            'ci.min' => 'La cédula de identidad debe tener al menos 7 caracteres.',
            'ci.max' => 'La cédula de identidad no puede exceder los 10 caracteres.',
            'ci.unique' => 'La cédula de identidad ya está en uso.',
            'ci.regex' => 'La cédula de identidad solo puede contener números.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.string' => 'El teléfono debe ser una cadena de texto.',
            'phone.min' => 'El teléfono debe tener al menos 8 caracteres.',
            'phone.max' => 'El teléfono no puede exceder los 10 caracteres.',
            'phone.unique' => 'El teléfono ya está en uso.',
            'phone.regex' => 'El teléfono solo puede contener números.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.regex' => 'El correo electrónico no tiene un formato válido.',
            'role_id.required' => 'El rol es obligatorio.',
            'role_id.exists' => 'El rol seleccionado no es válido.',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->ci = $request->input('ci');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->save();
        return redirect()->route('users')->with('icon', 'success')->with('title', 'Usuario actualizado')->with('message', 'Los datos del usuario se han actualizado exitosamente.');

        //return response()->json($request);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users')->with('icon', 'success')->with('title', 'Usuario eliminado')->with('message', 'El usuario se ha eliminado exitosamente.');
    }
}
