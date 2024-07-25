<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/join', function () {
    return view('join');
})->name('join');

Route::get('/create', function () {
    return view('create');
})->name('create');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/messages/room/{roomId}', [HomeController::class, 'messages'])->name('messages');
Route::post('/message', [HomeController::class, 'message'])->name('message');
Route::post('/new-room', [RoomController::class, 'store'])->name('newroom');
Route::post('/join-room', [RoomController::class, 'join'])->name('joinroom');