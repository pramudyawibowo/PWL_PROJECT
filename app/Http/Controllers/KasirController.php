<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kasir = User::where('level', 'kasir')->get();
        return view('kasir.index', compact('kasir'));
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

        $kasir = new User;
        $kasir->name = $request->get('name');
        $kasir->email = $request->get('email');
        $kasir->password = bcrypt($request->get('password'));
        $kasir->level = $request->get('level');
        $kasir->foto = $image_name;
        $kasir->remember_token = Str::random(60);
        $kasir->save();

        return redirect()->route('kasir.index')
            ->with('success', 'Kasir Berhasil Ditambahkan');;
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

        $kasir = User::find($id);

        if($request->has('fotoprofil')){
            if($kasir->foto != 'images/user_profile/user.png' && file_exists(storage_path('app/public/'.$kasir->foto))){
                Storage::delete('public/'.$kasir->foto);
            }
            $image_name = $request->file('fotoprofil')->store('images/user_profile', 'public');
            $kasir->foto = $image_name;
        }

        $kasir->name = $request->get('name');
        $kasir->email = $request->get('email');
        $kasir->level = $request->get('level');
        if($request->filled('password')){
            $kasir->password = bcrypt($request->get('password'));
        }
        $kasir->save();

        return redirect()->route('kasir.index')
            ->with('success', 'Kasir berhasil diupdate');
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
        return redirect()->route('admin.index')
            ->with('success', 'Kasir berhasil dihapus');
    }
}
