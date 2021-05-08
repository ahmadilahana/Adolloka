<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Toko;
use App\Models\Barang;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;
        // echo $user;
        $toko = Toko::where('akun_id', $user)->first();
        return response()->json(compact('toko'), 200);
    }

    public function cektoko(Request $request)
    {
        $id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $toko = Toko::create([
            "nama_toko" => $request->get("nama"),
            "alamat" => $request->get("alamat"),
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
        ])->first();
        
        return response()->json(["toko" => $toko], 200);
    }

    public function getbarang()
    {
        $user = auth()->user()->id;
        $id = Toko::where('akun_id', $user)->first();
        // echo $id;

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
