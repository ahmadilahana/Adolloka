<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;
use App\Models\KategoriBarang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::all()->load('toko');
        $data->load('foto');
        return response()->json(compact('data'), 200);
    }

    public function show($id_barang)
    {
        $data = Barang::where('id', $id_barang)->first()->load('toko');

        return response()->json(compact('data'), 200);
    }

    public function kategori()
    {
        $kat = KategoriBarang::all();
        return response()->json(compact('kat'), 200);
    }

    
    public function barangPerKategori($id_kategori)
    {
        $kat = KategoriBarang::find($id_kategori);
        $kat->load('barang');
        $kat['barang']->load('toko', 'foto');
        return response()->json(compact('kat'), 200);
    }
}
