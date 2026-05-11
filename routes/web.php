<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    // Ini buat logic controller be nya
    return redirect()->route('predict');
})->name('login.submit');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function () {
    // ini jg be
    return redirect()->route('predict');
})->name('register.submit');

Route::get('/predict', function () {
    return view('transfer-details');
})->name('predict');

Route::post('/predict', function () {
    // ini jg buat proses fraud prediction
    return redirect()->route('result');
})->name('predict.submit');

Route::get('/about', function () {
    return view('about');
})->name('about');

//ini buat ngetes jdi jgn dijalanin dua duanya ntr crash

//ini kalo mau merah
Route::get('/result', function () {
    return view('result', [
        'isFraud' => true
    ]);
})->name('result');

//ini kalo mau ijo
// Route::get('/result', function () {
//     return view('result', [
//         'isFraud' => false
//     ]);
// })->name('result');