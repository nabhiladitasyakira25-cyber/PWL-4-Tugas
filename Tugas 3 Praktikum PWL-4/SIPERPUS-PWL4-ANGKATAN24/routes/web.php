<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    return 'Hello World';
});

Route::get('/trial', function(){
    return 'Halaman dialihkan';
})->name('trial');

Route::redirect('/test', '/trial');

Route::view('/mhs', 'mahasiswa', ['nama' => 'Jhon Doe']);

Route::get('/mhslagi/{nama?}', function($name = 'User'){
    return view('mahasiswa', ['nama' => $name]);
})->name('mahasiswa');

Route::get('/data', [MahasiswaController::class, 'tampilData']);