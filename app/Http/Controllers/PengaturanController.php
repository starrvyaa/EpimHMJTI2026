<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengaturan;

class PengaturanController extends Controller
{
    public function index(){
        $data = pengaturan::firstOrCreate(
            ['id' => 1],
            [
                'status_pendaftaran_ditutup' => 0,
                'status_upload_postervideo_ditutup' => 0,
                'status_pengumpulan_karya' => 1,
            ]
        );
        return view('admin.pengaturan', compact('data'));
    }

    public function store(Request $request)
    {
        $data = pengaturan::firstOrCreate(
            ['id' => 1],
            [
                'status_pendaftaran_ditutup' => 0,
                'status_upload_postervideo_ditutup' => 0,
                'status_pengumpulan_karya' => 1,
            ]
        );

        $data->update([
            'status_pendaftaran_ditutup' => $request->status_pendaftaran_buka == 'on' ? 0 : 1,
            'status_upload_postervideo_ditutup' => $request->status_upload_postervideo_buka == 'on' ? 0 : 1,
            'status_pengumpulan_karya' => $request->status_pengumpulan_karya_buka == 'on' ? 1 : 0,
        ]);

        // ► FITUR 9: Log aktivitas admin
        $admin = auth()->user();
        \App\Models\ActivityLog::create([
            'admin_id'    => $admin->id,
            'admin_name'  => $admin->name,
            'action'      => 'Mengubah Pengaturan',
            'target_type' => 'pengaturan',
            'target_id'   => 1,
            'target_name' => 'Pengaturan Sistem',
            'keterangan'  => 'Pendaftaran: ' . ($request->status_pendaftaran_buka == 'on' ? 'BUKA' : 'TUTUP') . 
                             ', Upload Proposal/Orisinalitas: ' . ($request->status_upload_postervideo_buka == 'on' ? 'BUKA' : 'TUTUP') .
                             ', Pengumpulan Karya: ' . ($request->status_pengumpulan_karya_buka == 'on' ? 'BUKA' : 'TUTUP'),
        ]);

        return redirect()->route('Pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan ');
    }
}
