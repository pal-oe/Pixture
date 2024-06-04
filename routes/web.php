<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Explore;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Reels as Livewirereels;
use App\Livewire\Reels;



Route::get(uri: '/dashboard', action: function () {
    return view(view: 'dashboard');
})->middleware(['auth', 'verified'])->name(name: 'dashboard');


Route::middleware('auth')->group(function () {
    Route::get(uri: '/profile',action: [ProfileController::class, 'edit'])->name(name: 'profile.edit');
    Route::patch(uri: '/profile',action: [ProfileController::class, 'update'])->name(name: 'profile.update');
    Route::delete(uri: '/profile',action: [ProfileController::class, 'destroy'])->name(name: 'profile.destroy');


    Route::get('/', Home::class)->name('Home');
    Route::get('/explore', Explore::class)->name('explore');
    Route::get('/reels', Livewirereels::class)->name('reels');


    Route::get('/profile/{user}',\App\Livewire\Profile\Home::class)->name('profile.home');
    Route::get('/profile/{user}/reels',\App\Livewire\Profile\Reels::class)->name('profile.reels');
    Route::get('/profile/{user}/saved',\App\Livewire\Profile\Saved::class)->name('profile.saved');
});



//Route::get('/explore', function () {
//    return view('This is the Explore page');
//})->name('explore');

//Route::get('/reels', function () {
//    return view('reels');
//})->name('reels');


require __DIR__.'/auth.php';
