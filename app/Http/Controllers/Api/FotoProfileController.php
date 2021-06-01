<?php

namespace App\Http\Controllers\Api;


use DB;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\AlamatUser;
use App\Models\FotoProfile;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FotoProfileController extends Controller
{
    public function index()
    {
        // $profile = DB::table('tb_ft_profile')->get();
        $profile = FotoProfile::firstOrFail();
        // dd($profile);
        return response()->json(compact('profile'));
    }

    public function cekprofile(Request $request)
    {
        $id = auth()->user()->id;
        //  echo $id;
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
        if ($request->hasFile('foto')) {
            $result = $request->file('foto')->storeOnCloudinary('adolloka/profile');
            $foto_id = $result->getPublicId();
            $foto = $result->getSecurePath();
            
            $profile = FotoProfile::create([
                'id' => $foto_id,
                'foto' => $foto,
            ]);

            $user = Profile::create([
                'profile_id' => $foto_id,
                'akun_id' => $id,
            ]);
    
            $id = $user->id;
    
            $lokasi = AlamatUser::create([
                'user_id' => $id,
                'jns_alamat' => 'Alamat Utama',
            ]);

            return response()->json(compact("profile"),200);
        }
    }

    public function update(Request $request, $id)
    {
        
        if ($request->hasFile('foto')) {
            // echo "apa";
            $result = $request->file('foto')->storeOnCloudinary('adolloka/profile');
            $foto_id = $result->getPublicId();
            $foto = $result->getSecurePath();
            $profile_id = Profile::where('akun_id', '=', $id)->first()->profile_id;
            if (! $profile_id) {
                echo "tidak ada gambar";
                $profile = FotoProfile::create([
                    'id' => $foto_id,
                    'foto' => $foto,
                ]);
            } else {
                // echo "ada gambar";
                // $profile_id = Profile::where('akun_id', '=', $id)->first()->profile_id;
                Cloudinary::destroy($profile_id);
                $profile = tap(FotoProfile::where('id', '=', $profile_id))->update([
                    'id' => $foto_id,
                    'foto' => $foto,
                ])->first();
            }
            
            $user = tap(Profile::where('akun_id', '=', $id))->update([
                'profile_id' => $foto_id,
                'akun_id' => $id,
            ])->first();
            $user->load("foto");
            return response()->json(compact("user"),200);
        }
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
