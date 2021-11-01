<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontak;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kontaks = Kontak::latest()->get();
        return view('kontak.index', compact('kontaks'));
    }

    public function overview()
    {
        $kontaks = Kontak::latest()->get();
        return view('kontak.overview', compact('kontaks'));
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
            'email' => 'required',
            'phone' => 'required',
            'location' => 'required',
        ]);

        //fungsi eloquent untuk menambah data
        Kontak::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('kontak.index')->with('success', 'Kontak Berhasil Disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kontaks = Kontak::findOrFail($id);
        return view('kontak.edit', compact('kontaks'));
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
        $contact = Kontak::findOrFail($id);

        $email = $request->input('email');
        $phone = $request->input('phone');
        $location = $request->input('location');  

        $contact->email = $email;

        $contact->save();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('kontak.index')->with('success', 'Contact Berhasil Di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kontak::findOrFail($id);
        $data->delete();
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('kontak.index')->with('success', 'Kontak Berhasil Dihapus');
    }
}
