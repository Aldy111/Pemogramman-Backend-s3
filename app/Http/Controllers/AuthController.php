<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        /**
         * Undocumented function
         *membuat fitur register
         *ambil input name,email, dan password
         *input data nya ke database menggunakan user model
         */

        $input = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ];

        $user = User::create($input);

        $data = [
            'message' => 'register successfully',

        ];
        return response()->json($data, 200);
    }
    public function login(Request $request)
    {
        /**
         * fitur login
         * ambil input email dan password dari user
         * ambil input email dan password dari database berdasarkan email
         * bandingkan data yang di input user dan data dari database
         */

        $input = [
            "email" => $request->email,
            "password" => $request->password
        ];

        $user = User::where('email', $input['email'])->first();

        if ($input['email'] = $user->email && Hash::check($input['password'], $user->password)) {
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'login is successfully',
                'token' => $token->plainTextToken
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'login is invalid'
            ];
            return response()->json($data, 401);
        }
    }
}
