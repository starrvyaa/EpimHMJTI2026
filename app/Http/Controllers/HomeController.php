<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Competition;
use App\Models\Timeline;
// use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $competitions = Competition::latest()->get();
        $timelines = Timeline::orderBy('date')->get();

        return view('home', compact('categories','competitions','timelines'));
    }

    public function detail($slug)
    {
        $competition = Competition::whereHas('category', function($q) use ($slug){
            $q->where('slug', $slug);
        })->firstOrFail();

        return view('detail', compact('competition'));
    }
}
