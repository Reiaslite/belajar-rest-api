<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeView;
use App\Models\Rating;
use App\Models\Tool;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator; // panggil library validator
use Illuminate\Support\Facades\Auth; // panggil library auth
use Illuminate\Http\Exceptions\HttpsResponseException; // panggil library HttpsResponseException


class RecipeController extends Controller
{
    public function show_recipes(){
        $recipes = Recipe::with('user')->where('status_resep', 'publish')->get();

        $data = [];
        foreach($recipes as $recipe) {
            array_push($data,[
                'idresep' =>$recipe->idresep,
                'judul' =>$recipe->judul,
                'gambar' => url($recipe->gambar),
                'nama' => $recipe->user->nama,
            ]);
        }
        return response()->json([
            "message" => "success",
            "data" => $data
        ],200);
    }

    public function recipe_by_id(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'idresep' => 'required',
            'email' => 'email'
        ]);

        if($validator->fails()){
            return messageError($validator->messages()->toArray());
        }

        $recipe = Recipe::where('status_resep', 'publish')
                        ->where('idresep', $id)
                        ->get();

        if($recipe->isEmpty()){
            return response()->json([
                "message" => "failed",
                "data" => "Recipe not found"
            ],404);
        }

        $tools = Tool::where('resep_idresep', $request->idresep)->get();
        $ingredients = Ingredient::where('resep_idresep', $request->idresep)->get();
        
        $data = [];
        foreach($recipe as $recipe){
            array_push($data, [
                'idresep' => $recipe->idresep,
                'judul' => $recipe->judul,
                'gambar' => url($recipe->gambar),
                'cara_pembuatan' => $recipe->cara_pembuatan,
                'video' => $recipe->video,
                'nama' => $recipe->user->nama
            ]);
        }

        $recipeData = [
            'recipe' => $data,
            'tools' => $tools,
            'ingredients' => $ingredients
        ];

        RecipeView::create([
            'email' => $request->email,
            'date' => now(),
            'resep_idresep' => $request->idresep
        ]);

        return response()->json([
            "message" => "success",
            "data" => $recipeData
        ],200);
    }

    public function rating(Request $request){
        $validator = Validator::make($request->all(),[
            'idresep' => 'required',
            'email' => 'required|email',
            'rating' => 'required|in:1,2,3,4,5'
        ]);

        if($validator->fails()){
            return messageError($validator->messages()->toArray());
        }

        Rating::create([
            'rating' => $request->rating,
            'review' => $request->review,
            'resep_idresep' => $request->idresep,
            'email_user' => $request->email
        ]);

        return response()->json([
            "data" => [
                "msg" => "Rating berhasil disimpan"
            ]
        ],200);
    }
}
