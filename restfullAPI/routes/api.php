<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// menggunakan method get untuk akses url dan apicontroller dan menjalankannya (read data)
Route::get('mahasiswa', 'apicontroller@get_data');

// menggunakan method post untuk insert data
Route::post('mahasiswa/insert_mahasiswa', 'apicontroller@insert_data_mahasiswa');

// menggunakan put untuk update data
Route::put('/mahasiswa/update/{nim}', 'apicontroller@update_data_mahasiswa');

// untuk hapus data
Route::delete('/mahasiswa/delete/{nim}', 'apicontroller@delete_data_mahasiswa');