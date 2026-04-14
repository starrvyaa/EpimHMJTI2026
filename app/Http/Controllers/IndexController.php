<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataDokumentasi = DB::table('dokumentasi')->get();
        $dataMedpart = DB::table('medpart')->get();
        $dataSponsor = DB::table('sponsor')->get();
        return view('index', compact('dataDokumentasi', 'dataMedpart', 'dataSponsor'));
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
    public function store(Request $req)
    {
        #ambil id lomba
        $lomba = 0;
        if ($req->lomba == "webpro") {
            $lomba = 1;
        } else {
            $lomba = 2;
        }

        // #ambil file
        $kartu_pelajar = $req->kartuPelajar;
        $foto_formal = $req->fotoFormal;
        $follow_ig_epim = $req->followIgEpim;
        $follow_ig_hmjti = $req->followIgHmjti;
        $subscribe = $req->subscribe;
        $follow_tiktok = $req->followTiktok;
        $proposal = $req->proposal;

        #membuat nama file
        $Filekartu_pelajar = $req->nama . '_kartuPelajar.' . $kartu_pelajar->extension();
        $Filefoto_formal = $req->nama . '_Foto.' . $foto_formal->extension();
        $Filefollow_ig_epim = $req->nama . '_buktiIgEpim.' . $follow_ig_epim->extension();
        $Filefollow_ig_hmjti = $req->nama . '_buktiIgHmjti.' . $follow_ig_hmjti->extension();
        $Filesubscribe = $req->nama . '_subscribe.' . $subscribe->extension();
        $Filefollow_tiktok = $req->nama . '_buktiTiktok.' . $follow_tiktok->extension();
        $Fileproposal = $req->nama . '_proposal.' . $proposal->extension();

        #insert db
        $id_pendaftar = DB::table('pendaftar')->insertGetId([
            'id_pendaftar' => null,
            'id_lomba' => $lomba,
            'nama' => $req->nama,
            'email' => $req->email,
            'asal_sekolah' => $req->asalSekolah,
            'nope' => $req->nope,
            'kartu_pelajar' => $Filekartu_pelajar,
            // 'foto' => $Filefoto_formal,
            // 'follow_ig_epim' => $Filefollow_ig_epim,
            // 'follow_ig_hmjti' => $Filefollow_ig_hmjti,
            // 'subscribe' => $Filesubscribe,
            // 'follow_tiktok' => $Filefollow_tiktok,
            'proposal' => $Fileproposal,
            'tanggal' => now()
        ]);
        $id_pendaftar_gambar = DB::table('pendaftar_gambar')->insertGetId([
            'foto_formal' => $Filefoto_formal,
            'follow_ig_epim' => $Filefollow_ig_epim,
            'follow_ig_hmj' => $Filefollow_ig_hmjti,
            'subscribe' => $Filesubscribe,
            'follow_tiktok' => $Filefollow_tiktok,
            'id_pendaftar' => $id_pendaftar,
        ]);

        #bikin direktori baru
        $public_directory = 'public/' . $id_pendaftar;
        Storage::makeDirectory('public/' . $id_pendaftar);
        storage_path('app/' . $public_directory);

        // #store ke storage
        $kartu_pelajar->storeAs($public_directory, $Filekartu_pelajar);
        $foto_formal->storeAs($public_directory, $Filefoto_formal);
        $follow_ig_epim->storeAs($public_directory, $Filefollow_ig_epim);
        $follow_ig_hmjti->storeAs($public_directory, $Filefollow_ig_hmjti);
        $subscribe->storeAs($public_directory, $Filesubscribe);
        $follow_tiktok->storeAs($public_directory, $Filefollow_tiktok);
        $proposal->storeAs($public_directory, $Fileproposal);

        return redirect('/')->with('success', 'Terimakasih Telah Mendaftar')->with('lomba', $lomba);
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
}
