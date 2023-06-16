<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['prefix' => 'libros'],
    function () {
        Route::get('/', 'LibrosController@index');
        Route::get('/{id}', 'LibrosController@show');
        Route::post('/', 'LibrosController@store');
        Route::put('/{id}', 'LibrosController@update');
        Route::delete('/{id}', 'LibrosController@destroy');
        Route::get('restore/{id}', 'LibrosController@restore');

        /* Libros online de lá de api.itbook.store */
        Route::get('online/new', 'LibrosController@librosOnline');
    }
);
