<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::paginate(10);
        return view('users.members_index', compact('members'));
        // Lógica para mostrar la lista de miembros --- IGNORE ---
    }
}
