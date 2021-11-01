<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\Profil;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\Pertanyaan;
use App\Models\Kontak;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $homes = Home::get();
      $beritas = Berita::get();
      $profils = Profil::get();
      $galeris = Galeri::get();
      return view('profil.overview', compact('homes', 'beritas', 'profils', 'galeris'));
    }
}
