<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisController extends Controller
{
    public function index()
    {
        return view('Auth.Regis');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|max:255',

        ]);
        $validateData['role'] = "Peserta";
        $validateData['password'] = Hash::make($validateData['password']);
        User::create($validateData);
        $request->session()->flash('success', 'Registrasi berhasil,silahkan login');
        return redirect('/Login');
    }
}
