<?php

use Illuminate\Support\Facades\Route;
use App\Services\ArrayGenerate;
use App\Services\ArraySort;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index', ['view' => view('pages.main', [])]);
});

Route::get('/{method}', function ($method) {
    $unsortedArray = ArrayGenerate::intArray(10);
    return view('index', ['view' => view('pages.sortResult', [
        'unsortedArray' => $unsortedArray,
        'sortedArray' => ArraySort::sort($unsortedArray, $method),
        ])        
    ]);
});


