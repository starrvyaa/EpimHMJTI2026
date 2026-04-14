<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengaturan;

class PengaturanController extends Controller
{
    public function index(){
        $data = pengaturan::where('id_pengaturan',1)->first();
        return view('components.Dashboard_page.pengaturanpage.indexpengaturan',compact('data'));
    }
    public function store(Request $request){
        
            $data = pengaturan::where('id_pengaturan',1);
            $data->update([
                'status_pendaftaran_ditutup' => $request->tutup_pendaftaran == 'on' ? 1 : 0,
                'status_upload_postervideo_ditutup' => $request->status_upload_postervideo_ditutup == 'on' ? 1 : 0,
            ]);              
        return redirect()->route('Pengaturan.index');
    }
}
