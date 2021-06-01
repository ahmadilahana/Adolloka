<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FotoBarang;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FotoBarangController extends Controller
{
    public function hapus(Request $request)
    {
        Cloudinary::destroy($request['id_foto']);
        FotoBarang::destroy($request['id_foto']);
        return response()->json('data berhasil dihapus', 200);
    }

    public function tambah(Request $request)
    {
        foreach ($request['foto'] as $key => $value) {
            $result = $value->storeOnCloudinary('adolloka/barang');
            $foto_id = $result->getPublicId();
            $foto = $result->getSecurePath();
            $foto = FotoBarang::create([
                'id' => $foto_id,
                'foto' => $foto,
                'barang_id' => $request['id'],
            ]);
        }
    }
}
