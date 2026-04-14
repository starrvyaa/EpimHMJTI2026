<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\tim;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $countTim = tim::count();
        $counttimuploadproposal = Pendaftar::where('proposal', '!=', null)->count();
        $ketuatim = User::where('role', 'Peserta')->where('password', '!=', null)->count();
        $peserta = User::where('role', 'Peserta')->count();
        $web = Pendaftar::where('id_lomba', 1)->count();
        $design = Pendaftar::where('id_lomba', 2)->count();
        $video = Pendaftar::where('id_lomba',3)->count();
        $poster = Pendaftar::where('id_lomba',4)->count();
        return view('components.Dashboard_page.dashboard', [
            'hitungtotaltim' => $countTim,
            'timsudahuploadproposal' => $counttimuploadproposal,
            'ketuatiaptim' => $ketuatim,
            'peserta' => $peserta,
            'timweb' => $web,
            'timdesign' => $design,
            'timvideo' => $video,
            'timposter' => $poster
        ]);
    }
    public function dashboardPeserta()
    {
        $datas = DB::table('v_tim_lomba')->where('id_user', Auth::user()->id_user)->get();
        return view('components.DashbuatPeserta.dashboardPeserta', compact('datas'));
    }

    public function peserta()
    {
        $pendaftar = Pendaftar::all();
        return view('components.Dashboard_page.dashPeserta', ['pendaftar' => $pendaftar]);
    }

    public function profile()
    {
        return view('components.Profile.view_profile');
    }

    // DashboardController.php
    public function timweb(Request $request)
    {
        $datas = DB::table('v_tim_lomba')->where('id_lomba', '=', 1);

        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'uploaded') {
                $datas = $datas->whereNotNull('proposal');
            } elseif ($request->input('sort_by') == 'not_uploaded') {
                $datas = $datas->whereNull('proposal');
            }
        }

        $datas = $datas->get();

        return view('components.Dashboard_page.adminPage.tim', compact('datas', 'request'));
    }

    public function timdesign(Request $request)
    {
        $datas = DB::table('v_tim_lomba')->where('id_lomba', '=', 2);

        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'uploaded') {
                $datas = $datas->whereNotNull('proposal');
            } elseif ($request->input('sort_by') == 'not_uploaded') {
                $datas = $datas->whereNull('proposal');
            }
        }

        $datas = $datas->get();

        return view('components.Dashboard_page.adminPage.tim', compact('datas', 'request'));
    }

    public function timposter(Request $request)
    {
        $datas = DB::table('v_tim_lomba')->where('id_lomba', '=', 4);

        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'uploaded') {
                $datas = $datas->whereNotNull('proposal');
            } elseif ($request->input('sort_by') == 'not_uploaded') {
                $datas = $datas->whereNull('proposal');
            }
        }

        $datas = $datas->get();

        return view('components.Dashboard_page.adminPage.tim', compact('datas', 'request'));
    }

    public function timvideo(Request $request)
    {
        $datas = DB::table('v_tim_lomba')->where('id_lomba', '=', 3);

        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'uploaded') {
                $datas = $datas->whereNotNull('proposal');
            } elseif ($request->input('sort_by') == 'not_uploaded') {
                $datas = $datas->whereNull('proposal');
            }
        }

        $datas = $datas->get();

        return view('components.Dashboard_page.adminPage.tim', compact('datas', 'request'));
    }


    public function lolos($id_pendaftar)
    {
        $tim = DB::table('pendaftar')->where('id_pendaftar', $id_pendaftar)->first();
        if ($tim) {
            DB::table('pendaftar')->where('id_pendaftar', $id_pendaftar)->update(['status_lolos' => 1]);
            return redirect()->back()->with('success', 'Status lolos updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Tim not found!');
        }
    }
}
