<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profil(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success =  $user;
        $success['token'] =  $user->createToken('MyApp', ['user'])->plainTextToken;
        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Register success!',
                'data' => $success,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register Gagal!'
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (Auth::guard()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::select('id', 'name', 'email', 'alamat', 'nohp', 'foto')->find(auth()->guard()->user()->id);
            $success = $user;
            $success['token'] =  $user->createToken('MyApp', ['user'])->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Login success!',
                'data' => $success,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed!',
            ], 401);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'nohp' => 'required|string',
            'alamat' => 'required|string',
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:3', // Misalnya password baru harus memiliki panjang minimal 6 karakter
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('id', $request->id)->first();

        if ($user && Hash::check($request->password_lama, $user->password)) {
            $user->password = Hash::make($request->password_baru);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->nohp = $request->nohp;
            $user->alamat = $request->alamat;
            $user->save();

            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Password lama tidak cocok atau pengguna tidak ditemukan.'
        ], 400);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json([
            'message' => 'Anda Berhasil Logout'
        ]);
    }
}
