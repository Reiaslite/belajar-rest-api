<?php

namespace App\Observers;

use App\Models\Ingredient;
use App\Models\Log;

class IngredientObserver
{
    /**
     * Handle the Ingredients "created" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function created(Ingredient $ingredient)
    {
        Log::create([
            'module' => 'tambah bahan',
            'action' => 'tambah bahan'.$ingredient->nama.'dengan id: '.$ingredient->resep_idresep,
            'useraccess' => '-'
        ]);
    }

    /**
     * Handle the Ingredients "updated" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function updated(Ingredients $ingredients)
    {
        //
    }

    /**
     * Handle the Ingredients "deleted" event.
     *
     * @param  \App\Models\Ingredients  $ingredients
     * @return void
     */
    public function deleted(Ingredient $ingredient)
    {
        Log::create([
            'module' => 'hapus bahan',
            'action' => 'hapus bahan'.$ingredient->nama.'dengan id: '.$ingredient->resep_idresep,
            'useraccess' => '-'
        ]);
    }

    /**
     * Handle the Ingredients "restored" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function restored(Ingredient $ingredient)
    {
        //
    }

    /**
     * Handle the Ingredients "force deleted" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function forceDeleted(Ingredient $ingredient)
    {
        //
    }
}
