<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TimController extends Controller
{
    //
    function showtim($id)
    {
        //$id = Crypt::decrypt($id);
        $data = DB::table('v_tim_lomba')->where('id_pendaftar', $id)->first();
        $datapeserta = DB::table('v_datapeserta')->where('id_tim', $data->id_tim)->get();
        // dd($datapeserta);  

        return view('components.Dashboard_page.adminPage.showtim', compact('data', 'datapeserta'));
    }

    function pesertashow($id)
    {
        //$id = Crypt::decrypt($id);
        $user = DB::table('v_datapeserta')->where('id_user', $id)->first();
        
        // dd($user);
        return view('components.Dashboard_page.adminPage.detailtim', compact('user'));
    }

    public function pdfview($file)
    {
        $filePath = storage_path('data_pendaftar/' . $file);
        return response()->file($filePath);
    }

    public function download($filename)
    {
        $filePath = storage_path('data_pendaftar/' . $filename);
        return response()->file($filePath);
    }

    public function lolos(Request $request, $id_pendaftar)
    {
        $tim = DB::table('v_tim_lomba')->where('id_pendaftar', $id_pendaftar)->first();
        if ($tim) {
            DB::table('v_tim_lomba')->where('id_pendaftar', $id_pendaftar)->update(['status_lolos' => 1]);
            return redirect()->back()->with('success', 'Status lolos updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Tim not found!');
        }
    }
}
