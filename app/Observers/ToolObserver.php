<?php

namespace App\Observers;

use App\Models\Tool;
use App\Models\Log;

class ToolObserver
{
    /**
     * Handle the Tool "created" event.
     *
     * @param  \App\Models\Tool  $tool
     * @return void
     */
    public function created(Tool $tool)
    {
        Log::create([
            'module' => 'tambah alat',
            'action' => 'tambah alat'.$tool->nama_alat.'dengan id: '.$tool->resep_idresep,
            'useraccess' => '-' // kita bisa trace ini dari log module tambah resep
        ]);
    }

    /**
     * Handle the Tool "updated" event.
     *
     * @param  \App\Models\Tool  $tool
     * @return void
     */
    public function updated(Tool $tool)
    {
        //
    }

    /**
     * Handle the Tool "deleted" event.
     *
     * @param  \App\Models\Tool  $tool
     * @return void
     */
    public function deleting(Tool $tool)
    {
        Log::create([
            'module' => 'hapus alat',
            'action' => 'hapus alat'.$tool->nama_alat.'dengan id: '.$tool->resep_idresep,
            'useraccess' => '-' // kita bisa trace ini dari log module tambah resep
        ]);
    }

    /**
     * Handle the Tool "restored" event.
     *
     * @param  \App\Models\Tool  $tool
     * @return void
     */
    public function restored(Tool $tool)
    {
        //
    }

    /**
     * Handle the Tool "force deleted" event.
     *
     * @param  \App\Models\Tool  $tool
     * @return void
     */
    public function forceDeleted(Tool $tool)
    {
        //
    }
}
