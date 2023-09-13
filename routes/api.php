<?php

use App\Http\Controllers\API\User\Auth\AuthController as UserAuthController;
use App\Http\Controllers\API\Admin\Auth\AuthController as AdminAuthController;
use App\Http\Controllers\API\Employee\Auth\AuthController as EmployeeAuthController;
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

/*********************************** Users Routes *************************************/
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'

    ],
    function () {
        Route::post('register', [UserAuthController::class, 'register']);
        Route::post('login', [UserAuthController::class, 'login']);
        Route::post('logout', [UserAuthController::class, 'logout']);
        Route::post('refresh', [UserAuthController::class, 'refresh']);
        Route::post('me', [UserAuthController::class, 'me']);

    }
);
/*********************************** End Users Routes *************************************/

/*********************************** Admins Routes *************************************/
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'admin/auth'

    ],
    function () {
        Route::post('register', [AdminAuthController::class, 'register']);
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::post('refresh', [AdminAuthController::class, 'refresh']);
        Route::post('me', [AdminAuthController::class, 'me']);

    }
);
/*********************************** End Admins Routes *************************************/

/*********************************** Employees Routes *************************************/
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'employee/auth'

    ],
    function () {
        Route::post('register', [EmployeeAuthController::class, 'register']);
        Route::post('login', [EmployeeAuthController::class, 'login']);
        Route::post('logout', [EmployeeAuthController::class, 'logout']);
        Route::post('refresh', [EmployeeAuthController::class, 'refresh']);
        Route::post('me', [EmployeeAuthController::class, 'me']);

    }
);
/*********************************** End Employees Routes *************************************/
