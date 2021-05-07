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
        $id = auth()->user()->load("profile")->profile->id;

        $data = AlamatUser::where('user_id', $id)->get();
        return response()->json(compact("data"), 200);
    }

    public function cekAlamat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $id = auth()->user()->load("profile")->profile->id;
        // echo auth()->user()->load("profile");
        if (! AlamatUser::where('user_id', $id)->where("jns_alamat", "Alamat Utama")->first()) {
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
            'jns_alamat' => 'required|string',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $id = auth()->user()->load("profile")->profile->id;
        
        AlamatUser::create([
            'alamat' => $request->get('alamat'),
            'jns_alamat' => $request->get('jns_alamat'),
            'user_id' => $id,
        ]);
        return response()->json(["Data Berhasil Disimpan
        "], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        AlamatUser::create([
            'alamat' => $request->get('alamat'),
            'jns_alamat' => 'Alamat Utama',
            'user_id' => $id,
        ]);
        return response()->json(["Data Berhasil Disimpan
        "], 200);
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
        $data = AlamatUser::where("user_id", $id)->where("jns_alamat", "Alamat Utama")->update([
            'alamat' => $request->get('alamat')
        ]);
        return response()->json(["Data Berhasil Dirubah"], 200);
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
