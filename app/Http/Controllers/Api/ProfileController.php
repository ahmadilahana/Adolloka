<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
// use App\Models\AlamatUser;
use Symfony\Component\HttpFoundation\File;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // $cek = Profile::where('akun_id', $id)->first();
        // $profile = Profile::where("akun_id", "=", $user->id)->first();
        $user->load("profile");
        $load_alamat = $user->Load("alamat");
        $profile = $user["profile"];
        if(($profile) || ($load_alamat)){
            // $profile = $user["profile"];
            if($load_alamat && $profile){
                $alamat = $this->sort_array($user['alamat'], "id");
                unset($user['alamat']);
                $foto = $profile->load('foto');
                $user->load('toko');
                $toko = $user['toko'];
                unset($user['toko']);
                unset($user['profile']);
                return response()->json(compact("user", "profile", "alamat", "toko"), 200);
            }elseif ($load_alamat) {
                $alamat = $this->sort_array($user['alamat'], "id");
                unset($user['alamat']);
                return response()->json(compact("user", "alamat"), 200);
            }else {
                $foto = $profile->load('foto');
                $user->load('toko');
                $toko = $user['toko'];
                unset($user['toko']);
                unset($user['profile']);
                return response()->json(compact("user", "profile", "toko"), 200);
            }
        }else{
            return response()->json(compact("user"), 200);
        }
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

    public function cekprofile(Request $request)
    {
        $id = auth()->user()->id;
        // dd($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'gender' => 'required',
            'tgl_lahir' => 'required|string|date',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        if(! Profile::where('akun_id', $id)->exists()){
            // echo "store";
            return $this->store($request, $id);
        }else {
            // echo "update";
            return $this->update($request, $id);
        }
    }

    public function store(Request $request, $id)
    {
        $user = Profile::create([
            'nama' => $request->get('nama'),
            'gender' => $request->get('gender'),
            'tgl_lahir' => $request->get('tgl_lahir'),
            'akun_id' => $id,
        ]);

        return response()->json(['pesan' => 'Data berhasil diubah', 'user' => $user], 200);
    }

    public function show($id)
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
        // dd($request->foto);
        $user = tap(Profile::where('akun_id', $id))->update([
            'nama' => $request->get('nama'),
            'gender' => $request->get('gender'),
            'tgl_lahir' => $request->get('tgl_lahir'),
        ])->first();
  
        return response()->json(['pesan' => "Data Berhasil Diubah", 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
