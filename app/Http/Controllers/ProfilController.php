<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Profil;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profils = Profil::latest()->get();
        return view('profil.index', compact('profils'));
    }

    public function overview()
    {
        $profils = Profil::latest()->get();
        return view('profil.overview', compact('profils'));
    }

    public function create()
    {
        return view('profil.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'profil' => 'required',
            'deskripsi' => 'required',
            'visi' => 'required',
            'misi' => 'required',
        ]);

        //fungsi eloquent untuk menambah data
        Profil::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('profil.overview')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profils = Profil::findOrFail($id);
        return view('profil.edit', compact('profils'));
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
        $about = Profil::findOrFail($id);
        
        $profil = $request->input('profil');
        $deskripsi = $request->input('deskripsi');  
        $visi = $request->input('visi'); 
        $misi = $request->input('misi');
        
        $about->profil = $profil;
        $about->deskripsi = $deskripsi;
        $about->visi = $visi;
        $about->misi = $misi;

        $about->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('profil.overview')->with('success', 'Data Berhasil Di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Profil::findOrFail($id);
        $data->delete();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('profil.overview')->with('success', 'Data Berhasil Dihapus');
    }
}
