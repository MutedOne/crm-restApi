<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PropertyStatusController;
use App\Http\Controllers\PropertyOwnerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\InterestedPropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ListingTypeController;
use App\Http\Controllers\ContactTypeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
Route::prefix('v1')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LogoutController::class, 'logout']);
        Route::apiResource('user', UserController::class);
        Route::apiResource('user-roles', UserRoleController::class);
        Route::apiResource('user-statuses', UserStatusController::class);
        Route::apiResource('lead-statuses', LeadStatusController::class);
        Route::apiResource('lead', LeadController::class);
        Route::apiResource('property', PropertyController::class);
        Route::apiResource('property-statuses', PropertyStatusController::class);
        Route::apiResource('property-types', PropertyTypeController::class);
        Route::apiResource('property-owners', PropertyOwnerController::class);
        Route::apiResource('interested-property', InterestedPropertyController::class);
        Route::apiResource('listing-types', ListingTypeController::class);
        Route::apiResource('contact-types', ContactTypeController::class);
        Route::apiResource('contact', ContactController::class);
    });
});
