<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use App\Models\User;
use App\Models\user_berkas;
use App\Models\Pendaftar;
use Auth;
use DB;
use Storage;


class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_tim)
    {
        return view('components.pesertaPage.anggota_page.tambahanggota', compact('id_tim'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store pendaftaran

        $id_tim = Crypt::decrypt($request->id_tim);
        $datapendaftaran = DB::table('v_tim_lomba')->where('id_tim', $id_tim)->first();
        $lomba;
        if ($datapendaftaran->id_lomba == 1) {
            $lomba = "WebProgramming";
        } else if($datapendaftaran->id_lomba == 2) {
            $lomba = "DesignPackaging";
        }else if($datapendaftaran->id_lomba == 3) {
            $lomba = "Videografi";
        }else if($datapendaftaran->id_lomba == 4) {
            $lomba = "Posterkaryailmiah";
        } else {
            $lomba = "Unknown";
        }
        
        $public_directory = $datapendaftaran->asal_sekolah . "_" . $lomba . "_" . $datapendaftaran->nama_tim . "_" . $datapendaftaran->nama_ketua;

        //buat nama file
        $Filekartu_pelajar = $request->nama_peserta . '_kartuPelajar.' . $request->kartu_pelajar->extension();
        $Filefoto_formal = $request->nama_peserta . '_FotoFormal.' . $request->foto_formal->extension();
        $Filefollow_ig_epim = $request->nama_peserta . '_buktiIgEpim.' . $request->bukti_follow_ig_epim->extension();
        $Filefollow_ig_hmjti = $request->nama_peserta . '_buktiIgHmjti.' . $request->bukti_follow_ig_hmjti->extension();
        $Filesubscribe = $request->nama_peserta . '_subscribe.' . $request->bukti_subscribe_hmjti->extension();
        $Filefollow_tiktok = $request->nama_peserta . '_buktiTiktok.' . $request->bukti_follow_tiktok_hmjti->extension();
        $storage = Storage::disk('data_pendaftar');

        //store 
        $email = $request->email_peserta;
        if (User::where('email', $email)->exists()) {
            return back()->with('alert', 'Email sudah terdaftar')->withInput();
        } else {
            $user = User::create([
                'name' => $request->nama_peserta,
                'email' => $email,
                'id_tim' => $id_tim,
            ]);
           
        }
        $userberkas =  user_berkas::updateOrCreate([
            'id_user' => $user->id_user,
            'id_tim' => $id_tim,
            'kartu_pelajar' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $request->nama_peserta, $request->kartu_pelajar, $Filekartu_pelajar),
            'foto_formal' =>  $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $request->nama_peserta, $request->foto_formal, $Filefoto_formal),
            'follow_ig_epim' =>  $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $request->nama_peserta, $request->bukti_follow_ig_epim, $Filefollow_ig_epim),
            'follow_ig_hmj' =>  $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $request->nama_peserta, $request->bukti_follow_ig_hmjti, $Filefollow_ig_hmjti),
            'follow_tiktok' =>  $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $request->nama_peserta, $request->bukti_follow_tiktok_hmjti, $Filesubscribe),
            'subscribe' =>  $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $request->nama_peserta, $request->bukti_subscribe_hmjti, $Filefollow_tiktok),
        ]);
        toastr()->success('Data Berhasil Di Simpan', 'Berhasil');
        return redirect()->route('Lomba.peserta.edit', Crypt::encrypt($datapendaftaran->id_pendaftar));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //   // Validate form data
    //   $this->validate($request, [
    //     'nama_peserta' => 'required|string|max:255',
    //     'email_peserta' => 'required|string|email|max:255|unique:peserta,email_peserta', // Unique validation for email
    //     'foto_kartu' => 'required|image|mimes:jpeg,png,jpg,gif',
    //     'foto_formal' => 'required|image|mimes:jpeg,png,jpg,gif',
    //     'bukti_follow_ig_epim' => 'required|image|mimes:jpeg,png,jpg,gif',
    //     'bukti_follow_ig_hmjti' => 'required|image|mimes:jpeg,png,jpg,gif',
    //     'bukti_subscribe_hmjti' => 'required|image|mimes:jpeg,png,jpg,gif',
    //     'bukti_follow_tiktok_hmjti' => 'required|image|mimes:jpeg,png,jpg,gif',
    //   ]);

    //   // Save data to database
    //   $peserta = new Pendaftar();
    //   $peserta->id_tim = $request->id_tim;
    //   $peserta->nama_peserta = $request->nama_peserta;
    //   $peserta->email_peserta = $request->email_peserta;

    //   // Handle file uploads
    //   if ($request->hasFile('foto_kartu')) {
    //     $fileName = $request->file('foto_kartu')->store('foto-kartu-peserta');
    //     $peserta->foto_kartu = $fileName;
    //   }

    //   if ($request->hasFile('foto_formal')) {
    //     $fileName = $request->file('foto_formal')->store('foto-formal-peserta');
    //     $peserta->foto_formal = $fileName;
    //   }

    //   if ($request->hasFile('bukti_follow_ig_epim')) {
    //     $fileName = $request->file('bukti_follow_ig_epim')->store('bukti-follow-ig-epim');
    //     $peserta->bukti_follow_ig_epim = $fileName;
    //   }

    //   if ($request->hasFile('bukti_follow_ig_hmjti')) {
    //     $fileName = $request->file('bukti_follow_ig_hmjti')->store('bukti-follow-ig-hmjti');
    //     $peserta->bukti_follow_ig_hmjti = $fileName;
    //   }

    //   if ($request->hasFile('bukti_subscribe_hmjti')) {
    //     $fileName = $request->file('bukti_subscribe_hmjti')->store('bukti-subscribe-hmjti');
    //     $peserta->bukti_subscribe_hmjti = $fileName;
    //   }

    //   if ($request->hasFile('bukti_follow_tiktok_hmjti')) {
    //     $fileName = $request->file('bukti_follow_tiktok_hmjti')->store('bukti-follow-tiktok-hmjti');
    //     $peserta->bukti_follow_tiktok_hmjti = $fileName;
    //   }

    //   $peserta->save();


    //   session()->flash('success', 'Peserta berhasil ditambahkan!');


    //   return redirect()->route('Peserta.index'); // Or another route as needed
    // }
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $user = DB::table('v_datapeserta')->where('id_user', $id)->first();
        // dd($user);
        return view('components.pesertaPage.anggota_page.detailanggota', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = DB::table('v_datapeserta')->where('id_user', $id)->first();
        return view('components.pesertaPage.anggota_page.editanggota', compact('user'));
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
        // dd($id);
        $datauser = User::where('id_user', $id)->first();
        $datapendaftaran = DB::table('v_tim_lomba')->where('id_tim', $datauser->id_tim)->first();
        $storage = Storage::disk('data_pendaftar');
        $lomba;
        if ($request->kategorilomba == 1) {
            $lomba = "WebProgramming";
        } elseif ($request->kategorilomba == 2) {
            $lomba = "DesignPackaging";
        } elseif ($request->kategorilomba == 3) {
            $lomba = "Videografi";
        } elseif ($request->kategorilomba == 4) {
            $lomba = "Posterkaryailmiah";
        } else {
            // handle default or invalid category
            $lomba = "Unknown";
        }
        $public_directory = $datapendaftaran->asal_sekolah . "_" . $lomba . "_" . $datapendaftaran->nama_tim . "_" . $datapendaftaran->nama_ketua;
        $datauser = User::find($id);

        $datauser->update([
            'name' => $request->nama_peserta,
            'email' => $request->email_peserta
        ]);

        $databerkas = user_berkas::where('id_user', $id);
        if ($request->hasFile('kartu_pelajar')) {
            $Filekartu_pelajar = $datauser->name . '_kartuPelajar.' . $request->kartu_pelajar->extension();
            $databerkas->update([
                'kartu_pelajar' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $datauser->name, $request->kartu_pelajar, $Filekartu_pelajar),
            ]);
        }
        if ($request->hasFile('foto_formal')) {
            $Filefoto_formal = $datauser->name . '_fotoFormal.' . $request->foto_formal->extension();
            $databerkas->update([
                'foto_formal' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $datauser->name, $request->foto_formal, $Filefoto_formal),
            ]);
        }
        if ($request->hasFile('bukti_follow_ig_epim')) {
            $FilefollowIgEpim = $datauser->name . '_buktiIgEpim.' . $request->bukti_follow_ig_epim->extension();
            $databerkas->update([
                'follow_ig_epim' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $datauser->name, $request->bukti_follow_ig_epim, $FilefollowIgEpim),
            ]);
        }
        if ($request->hasFile('bukti_follow_ig_hmjti')) {
            $FilefollowIgHmj = $datauser->name . '_buktiIgHmjti.' . $request->bukti_follow_ig_hmjti->extension();
            $databerkas->update([
                'follow_ig_hmj' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $datauser->name, $request->bukti_follow_ig_hmjti, $FilefollowIgHmj),
            ]);
        }
        if ($request->hasFile('bukti_subscribe_hmjti')) {
            $FileSubs = $datauser->name . '_subscribe.' . $request->bukti_subscribe_hmjti->extension();
            $databerkas->update([
                'subscribe' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $datauser->name, $request->bukti_subscribe_hmjti, $FileSubs),
            ]);
        }
        if ($request->hasFile('bukti_follow_tiktok_hmjti')) {
            $FilefollowTiktok = $datauser->name . '_buktiTiktok.' . $request->bukti_follow_tiktok_hmjti->extension();
            $databerkas->update([
                'follow_tiktok' => $storage->putFileAs($public_directory . '/berkas_peserta' . '/' . $datauser->name, $request->bukti_follow_tiktok_hmjti, $FilefollowTiktok),
            ]);
        }
        toastr()->success('Data Berhasil Di Ubah', 'Berhasil');
        return redirect()->route('Lomba.peserta.edit', Crypt::encrypt($datapendaftaran->id_pendaftar));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $datapendaftaran = DB::table('v_tim_lomba')->where('id_user', Auth::user()->id_user)->first();
        $lomba;
        if ($datapendaftaran->id_lomba == 1) {
            $lomba = "WebProgramming";
        } else if($datapendaftaran->id_lomba == 2) {
            $lomba = "DesignPackaging";
        }else if($datapendaftaran->id_lomba == 3) {
            $lomba = "Videografi";
        }else if($datapendaftaran->id_lomba == 4) {
            $lomba = "Posterkaryailmiah";
        } else {
            $lomba = "Unknown";
        }
        $storage = Storage::disk('data_pendaftar');
        $public_directory = $datapendaftaran->asal_sekolah . "_" . $lomba . "_" . $datapendaftaran->nama_tim . "_" . $datapendaftaran->nama_ketua;
        $userfolder = $public_directory . '/berkas_peserta/' . $user->name;
        if ($storage->exists($userfolder)) {
            $storage->deleteDirectory($userfolder);
        }
        $user->delete();
        toastr()->success('Data Berhasil Di Ubah', 'Berhasil');
        return redirect()->route('Lomba.peserta.edit', Crypt::encrypt($datapendaftaran->id_pendaftar));
    }
}
