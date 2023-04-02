<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; // panggil model User
use App\Models\Log;
use Firebase\JWT\JWT; // panggil library JWT
use Illuminate\Support\Facades\Validator; // panggil library validator
use Illuminate\Support\Facades\Auth; // panggil library auth
use Illuminate\Http\Exceptions\HttpsResponseException; // panggil library HttpsResponseException

class AuthController extends Controller
{

    public function login(Request $request){
        // validasi inputan
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // jika validasi gagal
        if($validator->fails()){
            // return MessageError::message($validator->messages()->toArray());
            return messageError($validator->messages()->toArray());
        }

        // cek apakah email dan password ada di database
        if(Auth::attempt($validator->validated())){

            $payload = [
                'nama' => Auth::user()->nama, // isi nama
                'role' => Auth::user()->role, // isi role
                'iat' => now()->timestamp, // waktu token dibuat
                'exp' => now()->timestamp + 7200 // token expired dalam 2 jam
            ];

            $token = JWT::encode($payload,env('JWT_SECRET_KEY'), 'HS256'); // generate token

            Log::create([
                'module' => 'Login',
                'action' => 'Login Akun',
                'useraccess' => Auth::user()->email
            ]);

            return response()->json([
                "data" => [
                    'msg' => "berhasil login",
                    'nama' => Auth::user()->nama,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role,
                ],
                "token" => "Bearer {$token}"
            ], 200); // return data dan token
        }
        return response()->json("Email atau password salah", 422);
    }

    // fungsi untuk register
    public function register(Request $request){
        // validasi inputan
        $validator = Validator::make($request->all(),[
            'nama' => 'required', // nama harus diisi
            'email' => 'required|email|unique:user,email', // email harus diisi, harus berupa email, dan harus unik
            'password' => 'required|min:8', // password harus diisi dan minimal 8 karakter
            'confirmation_password' => 'required|same:password' // confirmation password harus diisi dan sama dengan password
        ]);

        // jika validasi gagal
        if($validator->fails()){
            // return MessageError::message($validator->messages()->toArray());
            return messageError($validator->messages()->toArray());
        };

        $user = $validator->validated(); // ambil data yang sudah divalidasi

        // masukkan data ke dalam database
        User::create($user);

        //isi token JWT
        $payload = [
            'nama' => $user['nama'], // isi nama
            'role' => 'user', // set role user
            'iat' => now()->timestamp, // waktu token dibuat
            'exp' => now()->timestamp + 7200 // token expired dalam 2 jam
        ];

        //generate token dengan algoritma HS256
        $token = JWT::encode($payload,env('JWT_SECRET_KEY'), 'HS256');

        //buat log in
        Log::create([
            'module' => 'Register',
            'action' => 'Register Akun',
            'useraccess' => $user['email']
        ]); 

        //kirim response ke pengguna
        return response()->json([
            "data" => [ // kirim data
                'msg' => "berhasil login", // kirim pesan berhasil
                'nama' => $user['nama'], // kirim nama
                'email' => $user['email'], // kirim email
                'role' => 'user', // set role user
            ],
            "token" => "Bearer {$token}" // kirim token
        ],200); // kirim response dengan status 200

    }
}
?>