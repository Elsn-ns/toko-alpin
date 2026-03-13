<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('chat.partials.widget', function ($view) {
            if (auth()->check() && auth()->user()->role === 'customer') {
                $conversation = \App\Models\Conversation::where('customer_id', auth()->id())->first();
                $messages = $conversation ? $conversation->messages()->with('sender')->get() : collect();
                
                $view->with([
                    'conversation' => $conversation,
                    'messages' => $messages,
                ]);
            }
        });
    }
}
