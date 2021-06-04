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
        if (count($request['id_barang']) >= 2) {
            $total_semua_harga = 0;
            foreach ($request['id_barang'] as $key => $value) {
                $data = Barang::find($request['id_barang'][$key]);
                $total_harga = 0;
                $total_harga = $total_harga + ($data['harga']*$request['jumlah'][$key]);
                $total_semua_harga += $total_harga;
                $id = auth()->user()->id;
                Chart::where("barang_id", $request['id_barang'][$key])->where('akun_id', $id)->delete();
                $alamat = AlamatUser::select("id")->where('akun_id', $id)->where('status', 'eneble')->first()->id;
                $transaksi[] = Transaksi::create([
                    'id' => date('Ymdhis') . $id,
                    'tgl_transaksi' => now(),
                    'barang_id' => $request['id_barang'][$key],
                    'toko_id' => $data['toko_id'],
                    'keterangan' => $request['keterangan'][$key],
                    'jumlah' => $request['jumlah'][$key],
                    'total_harga' => $total_harga,
                    'akun_id' => $id,
                    'alamat_id' => $alamat,
                    'status' => 'pembayaran',
                ]);
            }
            return response()->json(compact('transaksi', 'total_semua_harga'), 200);
        } else {
            // echo now();
            $data = Barang::find($request['id_barang'][0]);
            $total_harga = 0;
            $total_harga = $total_harga + ($data['harga']*$request['jumlah'][0]);
            $id = auth()->user()->id;
            $alamat = AlamatUser::select("id")->where('user_id', (Profile::select('id')->where('akun_id', $id)->first()->id))->where('status', 'eneble')->first()->id;
            $transaksi = Transaksi::create([
                'id' => date('Ymdhis') . $id,
                'tgl_transaksi' => now(),
                'barang_id' => $request['id_barang'][0],
                'toko_id' => $data['toko_id'],
                'keterangan' => $request['keterangan'][0],
                'jumlah' => $request['jumlah'][0],
                'total_harga' => $total_harga,
                'akun_id' => $id,
                'alamat_id' => $alamat,
                'status' => 'pembayaran',
            ]);
            return response()->json(compact('transaksi'), 200);
        }
        
    }

    public function sudahbayar(Request $request)
    {
        echo date("Ymdhsi");
    }
}
