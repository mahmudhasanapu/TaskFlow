<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    //Auth class
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/me',[AuthController::class, 'me']);
        Route::post('/logout',[AuthController::class, 'logout']);

         //Get Trashed Tasks
        Route::get('tasks/summary', [TaskController::class, 'summary']);
        Route::get('tasks/trashed', [TaskController::class, 'trashed']);

        //profile update
        Route::patch('/profileUpdate', [ProfileController::class, 'update']);

        //Task routes-CRUD operation
        Route::apiResource('tasks', TaskController::class);
        //Restoring
        Route::post('tasks/{id}/restore', [TaskController::class, 'restore']);
        //ForceDelete
        Route::delete('tasks/{id}/forceDelete', [TaskController::class, 'forceDelete']);

        //Filter Tasks Status
        Route::get('/tasksFilter', [TaskController::class, 'TaskFilter']);
        
        //Update Status
        Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus']);

       

    });
});
