<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IncomingProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EtalaseController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return redirect()->route('etalase.index');
});

// Store Showcase (Public Access)
Route::get('/etalase', [EtalaseController::class, 'index'])->name('etalase.index');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Customer Chat Route
    Route::get('/chat', [ChatController::class, 'customerIndex'])->name('chat.customer');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Backend / Staff & Admin Shared Routes
    Route::middleware(['staff'])->group(function () {
        // Common viewing
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        
        // POS & Transactions
        Route::resource('pos', TransactionController::class)->names('pos');
        Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::get('/transactions/{transaction}/print', [TransactionController::class, 'printInvoice'])->name('transactions.print');
        Route::get('/transactions/{transaction}/success', [TransactionController::class, 'success'])->name('transactions.success');
        
        // Staff Inbox
        Route::get('/inbox', [ChatController::class, 'staffInbox'])->name('chat.inbox');
        Route::get('/inbox/{conversation}', [ChatController::class, 'staffShow'])->name('chat.inbox.show');
        Route::get('/api/conversations', [ChatController::class, 'getConversationsApi'])->name('chat.api.conversations');
        Route::get('/api/messages/{conversation}', [ChatController::class, 'getMessagesApi'])->name('chat.api.messages');
        
        // Admin Only Routes
        Route::middleware(['admin'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            
            // Full Product Management
            Route::resource('products', ProductController::class)->except(['index']);
            Route::resource('incoming-products', IncomingProductController::class);
            
            Route::resource('staff', \App\Http\Controllers\StaffController::class)->except(['show']);
        });
    });
});

require __DIR__.'/auth.php';
