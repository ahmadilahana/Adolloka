<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\AlamatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlamatUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;

        $data = AlamatUser::where('akun_id', $id)->get();
        $data = $this->sort_array($data, "id");
        return response()->json(compact("data"), 200);
    }

    public function sort_array($array, $jenis)
    {
        $short = [];

        foreach ($array as $key => $value) {
            $short[$array[$key][$jenis]] = $value;
        }
        ksort($short);

        $hasil = [];

        foreach ($short as $key => $value) {
            $hasil[] = $value;
        }
        return $hasil;
    }

    public function cekAlamat(Request $request)
    {
        $id = auth()->user()->id;
        // echo auth()->user()->load("profile");
        if (! AlamatUser::where('akun_id', $id)->where("jns_alamat", "Alamat Utama")->first()) {
            // echo "alamat baru";
            return $this->store($request, $id);

        } else {

            return $this->update($request, $id);
        }
        
    }

    public function alamatbaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kd_pos' => 'required|numeric',
            'jns_alamat' => 'required|string',
            'penerima' => 'required|string',
            'no_hp' => 'required|numeric',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $id = auth()->user()->id;
        
        AlamatUser::create([
            'penerima' => $request->get('penerima'),
            'no_hp' => $request->get('no_hp'),
            'alamat' => $request->get('alamat'),
            'desa' => $request->get('desa'),
            'kecamatan' => $request->get('kecamatan'),
            'kota' => $request->get('kota'),
            'provinsi' => $request->get('provinsi'),
            'kd_pos' => $request->get('kd_pos'),
            'jns_alamat' => $request->get('jns_alamat'),
            'status' => 'diseble',
            'akun_id' => $id,
        ]);
        return response()->json(["Data Berhasil Disimpan
        "], 200);
    }
    public function store(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kd_pos' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if ($profile = Profile::where('akun_id', $id)->first()) {
            $penerima = $profile['nama']; 
        } else {
            $penerima = auth()->user()->username;
        }
        

        // echo $id;
        // dd($no_hp);
        $alamat = AlamatUser::create([
            'penerima' => $penerima,
            'no_hp' => auth()->user()->no_hp,
            'alamat' => $request->get('alamat'),
            'desa' => $request->get('desa'),
            'kecamatan' => $request->get('kecamatan'),
            'kota' => $request->get('kota'),
            'provinsi' => $request->get('provinsi'),
            'kd_pos' => $request->get('kd_pos'),
            'jns_alamat' => 'Alamat Utama',
            'status' => 'eneble',
            'akun_id' => $id,
        ]);
        return response()->json(["Data Berhasil Disimpan
        ", compact('alamat')], 200);
    }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kd_pos' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = AlamatUser::where("akun_id", $id)->where("jns_alamat", "Alamat Utama")->update([
            'alamat' => $request->get('alamat'),
            'desa' => $request->get('desa'),
            'kecamatan' => $request->get('kecamatan'),
            'kota' => $request->get('kota'),
            'provinsi' => $request->get('provinsi'),
            'kd_pos' => $request->get('kd_pos'),
        ]);
        return response()->json(["Data Berhasil Dirubah"], 200);
    }

    public function edit(Request $request, $id_alamat)
    {
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'provinsi' => 'required|string',
            'kd_pos' => 'required|numeric',
            'jns_alamat' => 'required|string',
            'penerima' => 'required|string',
            'no_hp' => 'required|numeric',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $id = auth()->user()->id;
        $data = AlamatUser::where("akun_id", $id)->where("id", $id_alamat)->update([
            'alamat' => $request->get('alamat'),
            'desa' => $request->get('desa'),
            'kecamatan' => $request->get('kecamatan'),
            'kota' => $request->get('kota'),
            'provinsi' => $request->get('provinsi'),
            'kd_pos' => $request->get('kd_pos'),
            'jns_alamat' => $request->get('jns_alamat'),
            'penerima' => $request->get('penerima'),
            'no_hp' => $request->get('no_hp'),
        ]);
        return response()->json(["Data Berhasil Dirubah"], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_alamat)
    {
        AlamatUser::destroy($id_alamat);
        return response()->json(['Data Berhasil Dihapus'], 200);
    }

    public function aktifAlamat($id_alamat)
    {
        
        $id = auth()->user()->id;

        AlamatUser::where('akun_id', $id)->update([
            'status' => "diseble",
        ]);

        AlamatUser::find($id_alamat)->update([
            'status' => "eneble",
        ]);

        return response()->json(["alamat berhasil diaktifkan"], 200);
    }
}
