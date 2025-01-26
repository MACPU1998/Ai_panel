<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/admin.php';


Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/data', [UserController::class, 'getUsersData'])->name('users.getData');
