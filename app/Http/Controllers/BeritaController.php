<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Galeri;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beritas = Berita::get();
        $galeris = Galeri::get();
        return view('berita.index', compact('beritas', 'galeris'));
    }

    public function overview()
    {
        $beritas = Berita::latest()->get();
        return view('berita.overview', compact('beritas'));
    }

    public function konten($id)
    {
        $beritas = Berita::findOrFail($id);
        return view('berita.konten', compact('beritas'));
    }

    public function create()
    {
        return view('berita.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
            'isi' => 'required',
        ]);
        
        $file = $request->gambar;
        $namaFile = $file->getClientOriginalName();
        $file->move(public_path().'/news_photos', $namaFile);
        Berita::create([
            "gambar" => $namaFile,
            "judul" => $request->judul,
            "deskripsi" => $request->deskripsi,
            "isi" => $request->isi
        ]);

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('berita.overview')->with('success', 'Berita Berhasil Tersimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beritas = Berita::findOrFail($id);
        return view('berita.edit', compact('beritas'));
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
        $berita = Berita::findOrFail($id);
        if($request->file('gambar') != null && $request->hasFile('gambar'))
        {
            $file = 'news_photos/'.$berita->gambar;
            if(is_file($file))
            {
                unlink($file);
            }
            $file = $request->file('gambar');
            $filename = $file->getClientOriginalName();
            $request->file('gambar')->move('news_photos/', $filename);
            $berita->gambar = $filename;
        }
        $berita->judul = $request->judul;
        $berita->deskripsi = $request->deskripsi;
        $berita->isi = $request->isi;
        $berita->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('berita.overview')->with('success', 'Berita berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Berita::findOrFail($id);
        $file = 'news_photos/'.$data->gambar;
        if(is_file($file))
        {
            unlink($file);
        }
        $data->delete();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('berita.overview')->with('success', 'Berita Berhasil Dihapus');
    }
}
