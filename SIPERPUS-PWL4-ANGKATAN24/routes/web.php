<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function () {
    $users = User::all();
    return view('user.index', compact('user'));
});

Route::get('/categories', function () {
    $users = Category::all();
    return view('categories.index', compact('categories'));
});

Route::get('/bookshelfs', function () {
    $users = User::all();
    return view('bookshelfs.index', compact('bookshelfs'));
});

Route::get('/book', function () {
    $users = Book::with('bookshelf')->get();
    return view('books.index', compact('books'));
});

Route::get('/loans', function () {
    $loans = Loan::with('user')->get();
    return view('loans.index', compact('loans'));
});

Route::get('/loan-details', function () {
    $loanDetails = LoanDetail::with('loan', 'book')->get();
    return view('loan_details.index', compact('loanDetails'));
});

Route::get('/returns', function () {
    $returns = ReturnModel::with('loanDetail')->get();
    return view('returns.index', compact('returns'));
});


// Route::get('/test', function(){
//     return 'Hello World';
// });

// Route::get('/trial', function(){
//     return 'Halaman dialihkan';
// })->name('trial');

// Route::redirect('/test', '/trial');

// Route::view('/mhs', 'mahasiswa', ['nama' => 'Jhon Doe']);

// Route::get('/mhslagi/{nama?}', function($name = 'User'){
//     return view('mahasiswa', ['nama' => $name]);
// })->name('mahasiswa');

// Route::get('/data', [MahasiswaController::class, 'tampilData']);