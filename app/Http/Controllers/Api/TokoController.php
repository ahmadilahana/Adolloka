<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Toko;
use App\Models\Barang;
use App\Models\FotoBarang;
use App\Models\Transaksi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TokoController extends Controller
{
    public function authtoko()
    {
        if (Toko::where('akun_id', auth()->user()->id)->exists()) {
            return true;
        } else {
            return false;
        }
        
    }
    public function index()
    {
        if ($this->authtoko()) {
            
            $user = auth()->user()->id;
            // echo $user;
            $toko = Toko::where('akun_id', $user)->first();
            return response()->json(compact('toko'), 200);
        }else {
            return response()->json("403 Forbidden", 403);
        }
    }

    public function cektoko(Request $request)
    {
        $id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kd_pos' => 'required|numeric',
            'domain_toko' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        if(! Toko::where('akun_id', $id)->exists()){
            // echo "store";
            return $this->store($request, $id);
        }else {
            // echo "update";
            return $this->update($request, $id);
        }
    }
    
    public function store(Request $request, $id)
    {
        $toko = Toko::create([
            "nama_toko" => $request->get("nama"),
            "alamat" => $request->get("alamat"),
            'desa' => $request->get('desa'),
            'kecamatan' => $request->get('kecamatan'),
            'kota' => $request->get('kota'),
            'provinsi' => $request->get('provinsi'),
            'kd_pos' => $request->get('kd_pos'),
            'domain_toko' => $request->get('domain_toko'),
            "akun_id" => $id,
        ]);
        
        return response()->json(compact('toko'), 200);
    }
    
    public function update(Request $request, $id)
    {
        // echo "update";
        $toko = tap(Toko::where("akun_id", "=", $id))->update([
            "nama_toko" => $request->get("nama"),
            "alamat" => $request->get("alamat"),
            'desa' => $request->get('desa'),
            'kecamatan' => $request->get('kecamatan'),
            'kota' => $request->get('kota'),
            'provinsi' => $request->get('provinsi'),
            'kd_pos' => $request->get('kd_pos'),
            'domain_toko' => $request->get('domain_toko'),
        ])->first();
        
        return response()->json(["toko" => $toko], 200);
    }

    public function getbarang()
    {
        if ($this->authtoko()) {
            
            $user = auth()->user()->id;
            $id = Toko::where('akun_id', $user)->first()->id;
            // echo $id;
            $data = Barang::where('toko_id', $id)->get();
            return response()->json(compact('data'), 200);

        } else {
            return response()->json("403 Forbidden", 403);
        }

    }

    public function tambahBarang(Request $request)
    {
        if ($this->authtoko()) {
            
            $user = auth()->user()->id;
            $id = Toko::where('akun_id', $user)->first()->id;
    
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'jumlah' => 'required|numeric',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                'kategori' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            $data = Barang::create([
                'nama' => $request->get('nama'),
                'jumlah' => $request->get('jumlah'),
                'harga' => $request->get('harga'),
                'deskripsi' => $request->get('deskripsi'),
                'kategori_id' => $request->get('kategori'),
                'toko_id' => $id,
            ]);
            // dd($request->file('foto'));
            if ($request->hasFile('foto')) {
                foreach ($request['foto'] as $key => $value) {
                    // dump($value);
                    $result = $value->storeOnCloudinary('adolloka/barang');
                    $foto_id = $result->getPublicId();
                    $foto = $result->getSecurePath();
                    $foto = FotoBarang::create([
                        'id' => $foto_id,
                        'foto' => $foto,
                        'barang_id' => $data['id'],
                    ]);
                }
            }
            return response()->json(['data berhasil ditambah'], 200);
        } else {
            return response()->json("403 Forbidden", 403);
        }
    }

    public function updateBarang(Request $request, $id_barang)
    {
        if ($this->authtoko()) {
            $user = auth()->user()->id;
            $id = Toko::where('akun_id', $user)->first()->id;
    
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'jumlah' => 'required|numeric',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                'kategori' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            Barang::where('toko_id', $id)->where('id', $id_barang)->update([
                'nama' => $request->get('nama'),
                'jumlah' => $request->get('jumlah'),
                'harga' => $request->get('harga'),
                'deskripsi' => $request->get('deskripsi'),
                'kategori_id' => $request->get('kategori'),
            ]);
            return response()->json(['data berhasil diubah'], 200);
        } else {
            return response()->json("403 Forbidden", 403);
        }
    }

    public function deletebarang($id_barang)
    {
        $barang = FotoBarang::select('id')->where('barang_id', $id_barang)->get();
        // dump($barang);
        Barang::destroy($id_barang);
        foreach ($barang as $value) {
            // echo $value;
            Cloudinary::destroy($value['id']);
        }
        FotoBarang::where('barang_id', $id_barang)->delete();
        return response()->json('data berhasil dihapus', 200);
    }
}
