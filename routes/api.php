<?php

use App\Http\Controllers\API\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/user', [UserController::class, 'getUsers'])
// ->middleware('checkRoleAssign')
;
Route::post('/user', [UserController::class, 'createUser'])
// ->middleware('checkRoleAssign')
;
Route::get('/user/{id}', [UserController::class, 'getUser'])
// ->middleware('checkRoleAssign')
;
Route::put('/user/{id}', [UserController::class, 'updateUser'])
// ->middleware('checkRoleAssign')
;
Route::delete('/user/{id}', [UserController::class, 'delUser'])
// ->middleware('checkRoleAssign')
;