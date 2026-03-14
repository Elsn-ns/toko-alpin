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
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->role === 'customer') {
                    $conversation = \App\Models\Conversation::where('customer_id', $user->id)->first();
                    $messages = $conversation ? $conversation->messages()->with('sender')->get() : collect();
                    $unread = $conversation ? $conversation->messages()->where('sender_id', '!=', $user->id)->where('is_read', false)->count() : 0;
                    $view->with([
                        'conversation' => $conversation,
                        'messages' => $messages,
                        'unread' => $unread,
                    ]);
                } elseif ($user->isStaff()) {
                    $conversations = \App\Models\Conversation::with(['customer', 'messages' => function($q) {
                        $q->latest()->take(1);
                    }])->orderBy('last_message_at', 'desc')->get();
                    $unread = \App\Models\Message::whereHas('conversation')
                        ->where('sender_id', '!=', $user->id)
                        ->where('is_read', false)
                        ->count();
                    $view->with([
                        'conversations' => $conversations,
                        'unread' => $unread,
                    ]);
                }
            }
        });
    }
}
