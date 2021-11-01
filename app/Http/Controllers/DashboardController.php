<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\Profil;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\Pertanyaan;
use App\Models\Kontak;

class DashboardController extends Controller
{
    // HOME
   public function home()
   {
      $homes = Home::get();
      $beritas = Berita::get();
      $profils = Profil::get();
      $galeris = Galeri::get();
      return view('home.index', compact('homes', 'beritas', 'profils', 'galeris'));
   }

   // ABOUT
   public function profil()
   {
      $profils = Profil::get();
      return view('profil.index', compact('profils'));
   }

   // GALLERY
   public function galeri()
   {
      $galeris = Galeri::get();
      return view('galeri.index', compact('galeris'));
   }
   // beritas
   public function berita()
   {
      $beritas = Beritas::get();
      $galeris = Galeri::get();
      return view('berita.index', compact('beritas', 'galeris'));
   }


   public function contact(Request $request)
   {
      return view('kontak.index');
   }
    
   public function pertanyaan(Request $request)
   {
      //melakukan validasi data
      $request->validate([
         'subjek' => 'required',
         'nama' => 'required',
         'email' => 'required',
         'deskripsi' => 'required',
      ]);
      Pesan::create($request->all());

      //jika data berhasil ditambahkan, akan kembali ke halaman utama
      return redirect()->route('kontak')->with('success', 'Pesan Sudah Terkirim');
   }

   public function contactUs()
   {
      $contacts = Contact::get();
      return view('layouts.layout', compact('kontaks'));
   }
}
