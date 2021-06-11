<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Profile;
use App\Models\AlamatUser;
use App\Models\BuktiTransaksi;
use App\Models\Toko;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TransaksiController extends Controller
{
    public function checkout(Request $request)
    {
        $total_harga = 0;
        foreach ($request['id_chart'] as $key => $value) {
            
            $file = Cart::find($value)->load('barang');
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
                Cart::where("barang_id", $request['id_barang'][$key])->where('akun_id', $id)->delete();
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
        
        $result = $request->file('foto')->storeOnCloudinary('adolloka/bukti_pembayaran');
        $foto_id = $result->getPublicId();
        $foto = $result->getSecurePath();

        BuktiTransaksi::create([
            'id' => $foto_id,
            'foto' => $foto,
            'transaksi_id' => $request->get('id_transaksi'),
        ]);

        Transaksi::find($request['id_transaksi'])->update([
            'status' => 'sudah dibayar',
        ]);

        return response()->json('data berhasil disimpan', 200);
    }

    public function editsudahbayar(Request $request)
    {
        $data = BuktiTransaksi::where('transaksi_id', $request['id_transaksi'])->first();
        // var_dump($data);
        Cloudinary::destroy($data['id']);
        $result = $request->file('foto')->storeOnCloudinary('adolloka/bukti_pembayaran');
        $foto_id = $result->getPublicId();
        $foto = $result->getSecurePath();
        $data->update([
            'id' => $foto_id,
            'foto' => $foto,
        ]);
        return response()->json('data berhasil diubah', 200);
    }
    public function index()
    {
        $id = auth()->user()->id;
        $data = Transaksi::where('akun_id', $id)->get()->load('barang');

        return response()->json($data, 200);
    }
    
    public function transaksitoko()
    {
        $id = Toko::where('akun_id', auth()->user()->id)->first()->id;
        $data = Transaksi::where('toko_id', $id)->get()->load('barang'); 
        return response()->json($data, 200);
    }

    public function detailtransaksi($id_transaksi)
    {
        $data = Transaksi::find($id_transaksi)->load('bukti', 'barang');

        return response()->json($data, 200);
    }

    public function pembayaranditolak($id_transaksi)
    {
        Transaksi::find($id_transaksi)->update([
            'status' => 'pembayaran ditolak'
        ]);

        return response()->json("data berhasil dirubah", 200);
    }
    
    public function pembayaranditerima($id_transaksi)
    {
        Transaksi::find($id_transaksi)->update([
            'status' => 'pembayaran diterima'
        ]);

        return response()->json("data berhasil dirubah", 200);
    }

    public function packing($id_transaksi)
    {
        Transaksi::find($id_transaksi)->update([
            'status' => 'packing'
        ]);

        return response()->json("data berhasil dirubah", 200);
    }

    public function pengiriman($id_transaksi)
    {
        Transaksi::find($id_transaksi)->update([
            'status' => 'pengiriman'
        ]);

        return response()->json("data berhasil dirubah", 200);
    }
    
    public function diterima($id_transaksi)
    {
        Transaksi::find($id_transaksi)->update([
            'status' => 'diterima'
        ]);

        return response()->json("data berhasil dirubah", 200);
    }
}
