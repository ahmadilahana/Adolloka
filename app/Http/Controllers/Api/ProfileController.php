<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\AlamatUser;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        // $cek = Profile::where('akun_id', $id)->first();
        // $profile = Profile::where("akun_id", "=", $user->id)->first();
        if($user->load("profile")){
            $profile = $user["profile"];
            $user['profile']->Load("alamat");
            $alamat = $user['profile']['alamat'];
            unset($user['profile']);
            unset($profile['alamat']);
        }
        return response()->json(compact("user", "profile", "alamat"), 200);
    }

    public function cekprofile(Request $request)
    {
        $id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'gender' => 'required',
            'tgl_lahir' => 'required|string|date',
            'alamat' => 'required|string',
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // return response()->json(["data create"], 200);
        

        $user = Profile::create([
            'nama' => $request->get('nama'),
            'gender' => $request->get('gender'),
            'tgl_lahir' => $request->get('tgl_lahir'),
            'akun_id' => $id,
            'foto' => $request->get('foto'),
        ]);

        $id = $user->id;

        $lokasi = AlamatUser::create([
            'alamat' => $request->get('alamat'),
            'user_id' => $id,
            'jns_alamat' => 'Alamat Utama',
        ]);
        return response()->json(['pesan' => 'Data berhasil diubah', 'user' => $user, 'lokasi' => $lokasi], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $user = tap(Profile::where('akun_id', $id))->update([
            'nama' => $request->get('nama'),
            'gender' => $request->get('gender'),
            'tgl_lahir' => $request->get('tgl_lahir'),
            'foto' => $request->get('foto'),
        ])->first();

        $id = $user->id;

        $lokasi = tap(AlamatUser::where('user_id', $id))->update([
            'alamat' => $request->get('alamat'),
            'jns_alamat' => 'Alamat Utama',
        ])->first();        
        return response()->json(['pesan' => "Data Berhasil Diubah", 'user' => [$user, $lokasi]], 200);
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
