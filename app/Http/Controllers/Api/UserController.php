<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        // dd($credentials);
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_akun'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:tb_akun',
            'no_hp' => 'required|string|unique:tb_akun',
            'email' => 'required|string|email|max:255|unique:tb_akun',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'no_hp' => $request->get('no_hp'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function editUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:tb_akun',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if (! Hash::check($request->get("password"), Hash::make(auth()->user()->password))) {
            return response()->json(['password' => 'The provided password does not match our records.'], 400);
        }

        $id = auth()->user()->id;

        $user = tap(User::find($id))->update([
            'username' => $request->get('username'),
        ])->first();
        return response()->json(['pesan' => "Username Diubah", 'user' => [$user]], 200);
    }

    public function editPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|max:255|unique:tb_akun,password',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if (! Hash::check($request->get("password"), Hash::make(auth()->user()->password))) {
            return response()->json(['password' => 'The provided password does not match our records.'], 400);
        }

        $id = auth()->user()->id;

        $user = tap(User::find($id))->update([
            'password' => $request->get('new_password'),
        ])->first();

        return response()->json(['pesan' => "password berhasil Diubah", 'user' => [$user]], 200);
    }

    public function editEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|unique:tb_akun',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        // var_dump(Hash::check($request->get("password"), Hash::make(auth()->user()->password)));
        if (! Hash::check($request->get("password"), Hash::make(auth()->user()->password))) {
            return response()->json(['password' => 'The provided password does not match our records.'], 400);
        }

        $id = auth()->user()->id;

        $user = tap(User::find($id))->update([
            'email' => $request->get('email'),
        ])->first();
        return response()->json(['pesan' => "email Diubah", 'user' => [$user]], 200);
    }

    public function editNoHp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => 'required|string|max:255|unique:tb_akun',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if (! Hash::check($request->get("password"), Hash::make(auth()->user()->password))) {
            return response()->json(['password' => 'The provided password does not match our records.'], 400);
        }

        $id = auth()->user()->id;

        $user = tap(User::find($id))->update([
            'no_hp' => $request->get('no_hp'),
        ])->first();
        return response()->json(['pesan' => "no hp Diubah", 'user' => [$user]], 200);
    }
}
