<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Receipt;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesanan = Order::all();
        $kategori = Category::all();
        $nota = Receipt::all();
        return view('pesanan.index', compact('pesanan', 'kategori', 'nota'));
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
            'nama_pelanggan',
            'alamat_pelanggan',
            'no_hp_pelanggan',
            'nama_barang',
            'id_kategori',
            'keluhan',
            'status',
        ]);

        $jumlahpesanan = Order::max('id');
        $kategori = Category::find($request->get('id_kategori'));

        $pesanan = new Order;
        $pesanan->nama_pesanan = (substr($kategori->nama_kategori, 0, 1)) . sprintf("%05d", $jumlahpesanan+1);
        $pesanan->nama_pelanggan = $request->get('nama_pelanggan');
        $pesanan->alamat_pelanggan = $request->get('alamat_pelanggan');
        $pesanan->no_hp_pelanggan = $request->get('no_hp_pelanggan');
        $pesanan->nama_barang = $request->get('nama_barang');
        $pesanan->id_kategori = $request->get('id_kategori');
        $pesanan->keluhan = $request->get('keluhan');
        $pesanan->status = $request->get('status');
        $pesanan->save();

        return redirect()->route('pesanan.index')
            ->with('success', 'Data pesanan berhasil ditambahkan');
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
            'nama_pesanan',
            'nama_pelanggan',
            'alamat_pelanggan',
            'no_hp_pelanggan',
            'nama_barang',
            'id_kategori',
            'keluhan',
        ]);

        $pesanan = Order::find($id);
        $pesanan->nama_pesanan = $request->get('nama_pesanan');
        $pesanan->nama_pelanggan = $request->get('nama_pelanggan');
        $pesanan->alamat_pelanggan = $request->get('alamat_pelanggan');
        $pesanan->no_hp_pelanggan = $request->get('no_hp_pelanggan');
        $pesanan->nama_barang = $request->get('nama_barang');
        $pesanan->id_kategori = $request->get('id_kategori');
        $pesanan->keluhan = $request->get('keluhan');
        $pesanan->save();

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();
        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }

    public function fix(Request $request, $id)
    {
        $request->validate([
            'estimasi_selesai',
        ]);
        $pesanan = Order::find($id);
        $pesanan->estimasi_selesai = $request->get('estimasi_selesai');
        $pesanan->status = 'diproses';
        $pesanan->save();
        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan diperbaiki');
    }
}
