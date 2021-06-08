<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlluserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alluser = User::all();
        return view('alluser.index', compact('alluser'));
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

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->level = $request->get('level');
        $user->foto = $image_name;
        $user->remember_token = Str::random(60);
        $user->save();

        return redirect()->route('alluser.index')
            ->with('success', 'User Berhasil Ditambahkan');;
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

        $alluser = User::find($id);

        if($request->has('fotoprofil')){
            if($alluser->foto != 'images/user_profile/user.png' && file_exists(storage_path('app/public/'.$alluser->foto))){
                Storage::delete('public/'.$alluser->foto);
            }
            $image_name = $request->file('fotoprofil')->store('images/user_profile', 'public');
            $alluser->foto = $image_name;
        }

        $alluser->name = $request->get('name');
        $alluser->email = $request->get('email');
        $alluser->level = $request->get('level');
        if($request->filled('password')){
            $alluser->password = bcrypt($request->get('password'));
        }
        $alluser->save();

        return redirect()->route('alluser.index')
            ->with('success', 'User berhasil diupdate');
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
        return redirect()->route('alluser.index')
            ->with('success', 'User berhasil dihapus');
    }
}
