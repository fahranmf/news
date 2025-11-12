<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// ini route untuk landing page news. Jadi pas user akses '/' akan diarahkan ke method index di NewsController
Route::get('/', [NewsController::class, 'index'])->name('news.index');

// ini route untuk menampilkan detail news berdasarkan id news yang diakses
// misal route nya jadi /news/1 maka method show akan menampilkan detail news dengan id 1
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
