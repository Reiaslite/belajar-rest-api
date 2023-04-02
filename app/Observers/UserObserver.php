<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Log;

class UserObserver
{

    public function creating(User $user){
        $user->last_login = now();
    }
    
    /**
     * Handle the UserObserver "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        Log::create([ // log disini
            'module' => 'register', // module disini
            'action' => 'register akun', // action disini
            'useraccess' => $user->email // useraccess disini
        ]);
    }

    /**
     * Handle the UserObserver "updated" event.
     *
     * @param  \App\Models\UserObserver  $userObserver
     * @return void
     */
    public function updated(User $user)
    {   
        Log::create([
            'modele' => 'sunting',
            'action' => 'sunting akun',
            'useraccess' => $user->email
        ]);
    }

    /**
     * Handle the UserObserver "deleted" event.
     *
     * @param  \App\Models\UserObserver  $userObserver
     * @return void
     */
    public function deleted(User $user)
    {
        Log::create([
            'module' => 'hapus',
            'action' => 'hapus akun',
            'useraccess' => $user->email
        ]);
    }

    /**
     * Handle the UserObserver "restored" event.
     *
     * @param  \App\Models\UserObserver  $userObserver
     * @return void
     */
    public function restored(UserObserver $userObserver)
    {
        //
    }

    /**
     * Handle the UserObserver "force deleted" event.
     *
     * @param  \App\Models\UserObserver  $userObserver
     * @return void
     */
    public function forceDeleted(UserObserver $userObserver)
    {
        //
    }
}
