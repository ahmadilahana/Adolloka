<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $id = auth()->user()->id;
        if ($jumlah = Cart::where('barang_id', $request['id_barang'])->where('akun_id', $id)->first()) {
            Cart::where('barang_id', $request['id_barang'])->where('akun_id', $id)->update([
                'jumlah' => $request['jumlah']+$jumlah['jumlah'],
            ]);
        } else {
            Cart::create([
                'akun_id' => $id,
                'barang_id' => $request->get('id_barang'),
                'jumlah' => $request->get('jumlah'),
            ]);
        }

        return response()->json(['Data berhasil ditambah'], 200);
    }

    public function delete($id)
    {
        Cart::destroy($id);

        return response()->json(['data bserhasil dihapus'], 200);
    }

    public function edit(Request $request, $id)
    {
        Cart::find($id)->update([
            'jumlah' => $request->get('jumlah'),
        ]);

        return response()->json(['data berhasil diubah'], 200);
    }

    public function index()
    {
        $id = auth()->user()->id;
        $data = Cart::where('akun_id', $id)->get();
        $data->load('barang');
        foreach ($data as $value) {
            $value['toko'] = $value['barang']->load('toko')->toko;
            unset($value['barang']['toko']);
            $value['barang']['kategori'] = DB::table('tb_kat_barang')->where('id', $value['barang']['kategori_id'])->first();
        }
        // dd($data);
        // $data = $data['barang'];
        return response()->json(compact('data'), 200);
    }
}
