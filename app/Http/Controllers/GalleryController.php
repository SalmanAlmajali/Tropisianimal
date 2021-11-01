<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Gallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('gallery.index', compact('galleries'));
    }

     public function create()
    {
        return view('gallery.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->gambar;
        $namaFile = $file->getClientOriginalName();
        $file->move(public_path().'/galery_photo', $namaFile);
        Gallery::create([
            'gambar' => $namaFile
        ]);

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('gallery.index')->with('success', 'Image Berhasil Tersimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $galleries = Gallery::findOrFail($id);
       return view('gallery.edit', compact('galleries'));
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
        $galery = Gallery::findOrFail($id);
        if($request->file('gambar') == null)
        {
            $galery->gambar = $galery->gambar;
        } else {
            if($request->hasFile('gambar'))
            {
                $file = 'galery_photo/'.$galery->gambar;
                if(is_file($file))
                {
                    unlink($file);
                }
                $file = $request->file('gambar');
                $filename = $file->getClientOriginalName();
                $request->file('gambar')->move('galery_photo/', $filename);
                $galery->gambar = $filename;
            }
        }
        $galery->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('gallery.index')->with('success', 'Image Berhasil Di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Gallery::findOrFail($id);
        $file = 'galery_photo/'.$data->gambar;
        if(is_file($file))
        {
            unlink($file);
        }
        $data->delete();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('gallery.index')->with('success', 'Berita Berhasil Dihapus');
    }
}
