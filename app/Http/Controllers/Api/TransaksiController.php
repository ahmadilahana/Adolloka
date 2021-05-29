<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chart;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Profile;
use App\Models\AlamatUser;

class TransaksiController extends Controller
{
    public function checkout(Request $request)
    {
        $total_harga = 0;
        foreach ($request['id_chart'] as $key => $value) {
            
            $file = Chart::find($value)->load('barang');
            $data[] = $file;
            $total_harga = $total_harga + ($file['barang']['harga']*$file['jumlah']);

        }
        return response()->json(compact('data','total_harga'), 200);
    }

    public function beli(Request $request)
    {
        $data = Barang::find($request['id_barang']);
        $total_harga = 0;
        $total_harga = $total_harga + ($data['harga']*$request['jumlah']);
        return response()->json(compact('data', "total_harga"), 200);
    }

    public function bayar(Request $request)
    {
        if (is_array($request['id_barang'])) {
            $total_harga = 0;
            foreach ($request['id_barang'] as $key => $value) {
                // echo "barang banyak";
                $data = Barang::find($request['id_barang']);
                $total_harga = $total_harga + ($data['harga']*$request['jumlah']);
            }
        } else {
            // echo now();
            $data = Barang::find($request['id_barang']);
            $total_harga = 0;
            $total_harga = $total_harga + ($data['harga']*$request['jumlah']);
            $id = auth()->user()->id;
            $alamat = AlamatUser::select("id")->where('user_id', (Profile::select('id')->where('akun_id', $id)->first()->id))->where('status', 'eneble')->first()->id;
            $transaksi = Transaksi::create([
                'tgl_transaksi' => now(),
                'barang_id' => $request['id_barang'],
                'toko_id' => $data['toko_id'],
                'keterangan' => $request['keterangan'],
                'jumlah' => $request['jumlah'],
                'total_harga' => $total_harga,
                'akun_id' => $id,
                'alamat_id' => $alamat,
                'status' => 'pembayaran',
            ]);
            return response()->json(compact('transaksi'), 200);
        }
        
    }
}
