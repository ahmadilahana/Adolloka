<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chart;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function add(Request $request)
    {
        $id = auth()->user()->id;

        Chart::create([
            'id_akun' => $id,
            'id_barang' => $request->get('id_barang'),
            'jumlah' => $request->get('jumlah'),
        ]);

        return response()->json(['Data berhasil ditambah'], 200);
    }

    public function delete($id)
    {
        Chart::destroy($id);

        return response()->json(['data bserhasil dihapus'], 200);
    }

    public function edit(Request $request, $id)
    {
        Chart::find($id)->update([
            'jumlah' => $request->get('jumlah'),
        ]);

        return response()->json(['data berhasil diubah'], 200);
    }

    public function index()
    {
        $id = auth()->user()->id;
        $data = Chart::where('id_akun', $id)->get();
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
