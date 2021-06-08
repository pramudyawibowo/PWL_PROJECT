<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teknisi = User::where('level', 'teknisi')->get();
        return view('teknisi.index', compact('teknisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name'      => 'required',
            'email'     => 'required',
            'password'  => 'required',
            'level'     => 'required',
        ]);

        if($request->file('fotoprofil')){
            $image_name = $request->file('fotoprofil')->store('images/user_profile', 'public');
        } else {
            $image_name = 'images/user_profile/user.png';
        }

        $teknisi = new User;
        $teknisi->name = $request->get('name');
        $teknisi->email = $request->get('email');
        $teknisi->password = bcrypt($request->get('password'));
        $teknisi->foto = $image_name;
        $teknisi->level = $request->get('level');
        $teknisi->remember_token = Str::random(60);
        $teknisi->save();

        return redirect()->route('teknisi.index')
            ->with('success', 'Teknisi Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'level'     => 'required',
        ]);

        $teknisi = User::find($id);

        if($request->has('fotoprofil')){
            if($teknisi->foto != 'images/user_profile/user.png' && file_exists(storage_path('app/public/'.$teknisi->foto))){
                Storage::delete('public/'.$teknisi->foto);
            }
            $image_name = $request->file('fotoprofil')->store('images/user_profile', 'public');
            $teknisi->foto = $image_name;
        }

        $teknisi->name = $request->get('name');
        $teknisi->email = $request->get('email');
        $teknisi->level = $request->get('level');
        if($request->filled('password')){
            $teknisi->password = bcrypt($request->get('password'));
        }
        $teknisi->save();

        return redirect()->route('teknisi.index')
            ->with('success', 'Teknisi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('teknisi.index')
            ->with('success', 'Teknisi berhasil dihapus');
    }
}
