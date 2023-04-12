<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(){
        return response()->json([
            "nama" => "Rai Tilosava De Araujo",
            "nim" => "21416255201184",
            "kelas" => "IF21B"
        ],200);
    }
}
