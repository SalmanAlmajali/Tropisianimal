<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galeris = Galeri::latest()->get();
        return view('galeri.index', compact('galeris'));
    }

     public function create()
    {
        return view('galeri.tambah');
    }

    public function overview()
    {
        $galeris = Galeri::latest()->get();
        return view('galeri.overview', compact('galeris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->foto;
        $namaFile = $file->getClientOriginalName();
        $file->move(public_path().'/galery_photo', $namaFile);
        Galeri::create([
            'foto' => $namaFile
        ]);

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('galeri.overview')->with('success', 'Image Berhasil Tersimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $galeris = Galeri::findOrFail($id);
       return view('galeri.edit', compact('galeris'));
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
        $galery = Galeri::findOrFail($id);
        if($request->file('foto') == null)
        {
            $galery->foto = $galery->foto;
        } else {
            if($request->hasFile('foto'))
            {
                $file = 'galery_photo/'.$galery->foto;
                if(is_file($file))
                {
                    unlink($file);
                }
                $file = $request->file('foto');
                $filename = $file->getClientOriginalName();
                $request->file('foto')->move('galery_photo/', $filename);
                $galery->foto = $filename;
            }
        }
        $galery->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('galeri.overview')->with('success', 'Image Berhasil Di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Galeri::findOrFail($id);
        $file = 'galery_photo/'.$data->foto;
        if(is_file($file))
        {
            unlink($file);
        }
        $data->delete();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('galeri.overview')->with('success', 'galeri Berhasil Dihapus');
    }
}
