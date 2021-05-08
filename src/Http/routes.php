<?php

use Dcat\Admin\DcatConfig\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-config', Controllers\DcatConfigController::class.'@index');