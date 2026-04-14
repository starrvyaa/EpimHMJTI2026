<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class LoginController extends Controller
{

    public function index()
    {
        return view('Auth.LoginPage');
    }

    public function LoginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'equired|email:dns',
            'password' => 'equired'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/Dashboard'); //if login success
        }

        return back()->with('loginError', 'Email or Password is incorrect!');
    }
    public function Authentic(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        // dd($email);
        if ($user != null) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                if (Auth::user()->role == "Admin") {
                    return redirect('dashboard');
                } else if (Auth::user()->role == "Peserta") {
                    return redirect('dashboardPeserta');
                } else {
                    return redirect('/Login')->withErrors(['error' => 'Invalid user role']);
                }
            } else {
                return redirect('/Login')->withErrors(['error' => 'Akun atau Password salah']);
            }
        } else {
            return redirect('/Login')->withErrors(['error' => 'Akun atau Password salah']);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Logout(Request $request)
    {
        Auth::Logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
