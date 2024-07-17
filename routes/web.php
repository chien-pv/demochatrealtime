<?php

use App\Events\ChatRealtime;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/{idchat}', function ($idchat) {
    // event(new ChatRealtime("Hello", 1));
    return view('welcome', ["idchat"=> $idchat ]);
});

Route::get('/chat/{id}/{message}', function ($id, $message) {
    event(new ChatRealtime($message, $id));
    return "done";
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
