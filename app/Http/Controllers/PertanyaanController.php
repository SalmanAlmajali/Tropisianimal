<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class PertanyaanController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pertanyaans = Pertanyaan::latest()->get();
        return view('kontak.index', compact('pertanyaans'));
    }

    public function overview()
    {
        $pertanyaans = Pertanyaan::latest()->get();
        return view('pertanyaan.overview', compact('pertanyaans'));
    }

    public function create()
    {
        return view('kontak.tambah');
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
            'subjek' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'deskripsi' => 'required',
        ]);

        //fungsi eloquent untuk menambah data
        Pertanyaan::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('kontak.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pertanyaans = Pertanyaan::findOrFail($id);
        return view('kontak.edit', compact('pertanyaans'));
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
        $question = Pertanyaan::findOrFail($id);
        
        $subjek = $request->input('subjek');
        $nama = $request->input('nama');  
        $email = $request->input('email'); 
        $deskripsi = $request->input('deskripsi');
        
        $question->subjek = $subjek;
        $question->nama = $nama;
        $question->email = $email;
        $question->deskripsi = $deskripsi;

        $question->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('kontak.overview')->with('success', 'Data Berhasil Di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pertanyaan::findOrFail($id);
        $data->delete();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('pertanyaan.overview')->with('success', 'Data Berhasil Dihapus');
    }
}