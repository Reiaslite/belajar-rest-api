<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\User; // panggil model user
use App\Observers\UserObserver; // panggil observer user

use App\Models\Recipe; // panggil model recipe
use App\Observers\RecipeObserver; // panggil observer recipe

use App\Models\Tool; // panggil model tool
use App\Observers\ToolObserver; // panggil observer tool

use App\Models\Ingredient; // panggil model ingredient
use App\Observers\IngredientObserver; // panggil observer ingredient

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class); // registrasikan disini
        Recipe::observe(RecipeObserver::class);
        Tool::observe(ToolObserver::class);
        Ingredient::observe(IngredientObserver::class);
    }
}
