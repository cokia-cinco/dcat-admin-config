<?php

use Dcat\Admin\DcatConfig\Http\Controllers\DcatConfigController;
use Dcat\Admin\DcatConfig\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('config', DcatConfigController::class.'@index');
Route::get('config/add', DcatConfigController::class.'@add');
Route::post('config/addo', DcatConfigController::class.'@addo');
Route::post('config.do', DcatConfigController::class.'@update');
Route::any('files', FileController::class.'@handle');
Route::delete('config/{id}', DcatConfigController::class.'@destroy');
Route::get('config/{id}/edit', DcatConfigController::class.'@edit');

Route::put('config/{id}', DcatConfigController::class.'@putEdit');
