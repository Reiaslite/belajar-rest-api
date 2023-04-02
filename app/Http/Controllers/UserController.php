<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Tool;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator; // panggil library validator
use Illuminate\Support\Facades\Auth; // panggil library auth
use Illuminate\Http\Exceptions\HttpsResponseException; // panggil library HttpsResponseException

class UserController extends Controller
{
    public function show_recipes(Request $request){
        $validator = Validator::make($request->all(),[
            'judul' => 'required|max:255',
            'gambar' => 'required|mimes:jpg,png,jpeg|max:2048',
            'cara_pembuatan' => 'required',
            'video' => 'required',
            'user_email' => 'required',
            'bahan' => 'required',
            'alat' => 'required'
        ]);

        if($validator->fails()){
            return messageError($validator->messages()->toArray());
        }

        $thumbnail = $request->file('gambar');
        $filename = now()->timestamp."-".$request->gambar->getClientOriginalName();
        $thumbnail->move('uploads', $filename);

        $recipeData = $validator->validated();

        $recipe = Recipe::create([
            'judul' => $recipeData['judul'],
            'gambar' => 'uploads/'. $filename,
            'cara_pembuatan' => $recipeData['cara_pembuatan'],
            'video' => $recipeData['video'],
            'user_email' => $recipeData['user_email'],
            'status_resep' => 'submit'
        ]);
    
        foreach(json_encode($request->bahan) as $bahan){
            Ingredient::create([
                'nama' => $bahan->nama,
                'satuan' => $bahan->satuan,
                'banyak' => $bahan->banyak,
                'keterangan' => $bahan->keterangan,
                'resep_idresep' => $recipe->id
            ]);
        }
    
        foreach(json_encode($request->alat) as $alat){
            Tool::create([
                'nama' => $alat->nama,
                'keterangan' => $alat->keterangan,
                'resep_idresep' => $recipe->id
            ]);
        }

        return response()->json([
            "data" => [
                "msg" => "resep berhasil disimpan",
                "resep" => $recipeData['judul']
            ]
        ]);

    }
}
