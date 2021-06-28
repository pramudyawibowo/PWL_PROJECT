<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nota = Receipt::all();
        return view('nota.index', compact('nota'));
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
            'id_pesanan',
            'diagnosa',
            'harga',
        ]);

        $nota = new Receipt;
        $nota->id_pesanan = $request->get('id_pesanan');
        $nota->diagnosa = $request->get('diagnosa');
        $nota->harga = $request->get('harga');
        $nota->nominal = 0;
        $nota->kembalian = 0;
        $nota->save();
        $pesanan = Order::find($request->get('id_pesanan'));
        $pesanan->status = 'selesai';
        $pesanan->save();

        return redirect()->route('pesanan.index')
            ->with('success', 'Nota berhasil ditambahkan');
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
            'id_pesanan',
            'diagnosa',
            'harga',
        ]);

        $nota = Receipt::find($id);
        $nota->id_pesanan = $request->get('id_pesanan');
        $nota->diagnosa = $request->get('diagnosa');
        $nota->harga = $request->get('harga');
        $nota->save();

        return redirect()->route('pesanan.index')
            ->with('success', 'Nota berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Receipt::find($id)->delete();
        return redirect()->route('nota.index')
            ->with('success', 'Nota berhasil dihapus');
    }

    public function cetakNota($id){
        $nota = Receipt::where('id_pesanan', $id)->with('pesanan')->first();
        return view('nota.index', compact('nota'));
    }

    public function pelunasan(Request $request, $id){

        $request->validate([
            'id_pesanan',
            'nominal',
        ]);

        $nota = Receipt::where('id_pesanan', $id)->first();

        if($request->get('nominal') < $nota->harga){
            return redirect()->route('pesanan.index')
                ->with('error', 'Nominal lebih kecil dari harga total!');
        } else {
            $nota->nominal = $request->get('nominal');
            $kembali = $request->nominal - $nota->harga;
            $nota->kembalian = $kembali;
            $nota->save();
            $pesanan = Order::find($request->get('id_pesanan'));
            $pesanan->status = 'lunas';
            $pesanan->save();

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dilunasi, kembalian sebesar Rp' . $kembali);
        }
    }
}
