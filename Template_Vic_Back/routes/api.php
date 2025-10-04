<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\TemplateController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/template', [TemplateController::class, 'create']);
    Route::get('/Freetemplate', [TemplateController::class, 'indexFreeTemplate']);
    Route::get('/indexFreeTemplateAdmin', [TemplateController::class, 'indexFreeTemplateAdmin']);
    Route::get('/indexFreeTemplateAdminHome', [TemplateController::class, 'indexFreeTemplateAdminHome']);
    Route::get('/indexFreeTemplateMosDownoald', [TemplateController::class, 'indexFreeTemplateMosDownoald']);

    Route::get('/TemplateStat', [TemplateController::class, 'TemplateStat']);
    Route::get('/Stat', [TemplateController::class, 'Stat']);

    Route::get('/indexPaidTemplateAdmin', [TemplateController::class, 'indexPaidTemplateAdmin']);
    Route::get('/PaidTemplate', [TemplateController::class, 'indexPaidTemplate']);
    Route::post('/ModifyVisibility', [TemplateController::class, 'ModifyVisibility']);
    Route::post('/Downoald', [TemplateController::class, 'DownoaldTemplate']);
    Route::post('/Rating', [TemplateController::class, 'Rating']);
    Route::post('/ShowRating', [TemplateController::class, 'ShowRating']);
    Route::post('/ShowCreator', [TemplateController::class, 'ShowCreator']);
    Route::post('/ContactCreator', [TemplateController::class, 'ContactCreator']);


    Route::get('user', function () { return auth()->user(); });
});
