<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(){
        return view('sale.sale');
    }
    public function searchmember(Request $request)
    {
        $request->validate([
            'member' => 'required|regex:/^[0-9]+$/|min:7|max:10|exists:members,ci',
        ], [
            'member.required' => 'El CI es obligatorio.',
            'member.regex'    => 'El CI debe contener solo números.',
            'member.min'      => 'El CI debe tener al menos 7 caracteres.',
            'member.max'      => 'El CI no debe tener más de 10 caracteres.',
            'member.exists'   => 'El usuario no está registrado en el sistema.',
        ]);
        $ci = $request->member;
        return response()->json($request);
    }
    Public function searchclient(Request $request)
    {
        $request->validate([
            'client' => 'required|regex:/^[0-9]+$/|min:7|max:10|exists:customers,ci',
        ], [
            'client.required' => 'El CI es obligatorio.',
            'client.regex'    => 'El CI debe contener solo números.',
            'client.min'      => 'El CI debe tener al menos 7 caracteres.',
            'client.max'      => 'El CI no debe tener más de 10 caracteres.',
            'client.exists'   => 'El usuario no está registrado en el sistema.',
        ]);
        $ci = $request->member;
        return response()->json($request);
    }
}
