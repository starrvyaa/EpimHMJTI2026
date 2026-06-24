<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
class ForgetPasswordManager extends Controller
{
    //
    function index(){
        return view('Auth.ForgotPassword');
    }

    function store(Request $request){
         $request->validate([
            'email' => "required|email|exists:users"
         ]);

         $token = Str::random(64);
         DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
         ]);

         Mail::send("emailsend.ForgotPassword",['token'=> $token],function($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
         });

         return redirect()->to(route("Forgot.page"))->with("success", "Email untuk reset kata sandi telah kami kirim. Mohon tunggu 5 menit. Jika email belum diterima, silakan ulangi proses lupa kata sandi..");
    }

    function reset($token){
        return view('Auth.newPass',compact('token'));
    }

    function resetPass(Request $request){
        $request->validate([
            "email" => "required|string|exists:users",
            "password" => "required|string|min:8|confirmed",
            "password_confirmation" => "required"
        ]);

        $updatePassword = DB::table('password_resets')
        ->where([
            "email" =>$request->email,
            "token" =>$request->token
        ])->first();

        if(!$updatePassword){
            return back()->with("loginError", "Email atau token reset password tidak valid.");
        }

        User::where("email",$request->email)->update(["password" =>Hash::make($request->password)]);

        DB::table("password_resets")->where(["email" => $request->email])->delete();

        return redirect('/Login')->with("success","Password reset success");
    }

}
