<?php


use App\Http\Controllers\Api\Client\HousingController;
use App\Http\Controllers\Api\Client\MenuController;
use App\Http\Controllers\Api\Institutional\ProjectController as InstitutionalProjectController;


use App\Http\Controllers\Api\Client\ProjectController;
use App\Http\Controllers\Api\Client\RealEstateController;
use App\Http\Controllers\Api\Client\SliderController as ClientSliderController;
use App\Http\Controllers\Api\Client\StoreController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayController;
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
Route::get('/featured-projects', [ProjectController::class, 'getFeaturedProjects']);
Route::get('/my_projects',[InstitutionalProjectController::class,"index"]);
Route::get('/featured-stores', [StoreController::class, 'getFeaturedStores']);
Route::get('/featured-sliders', [ClientSliderController::class, 'getFeaturedSliders']);
Route::get('dashboard-statuses',[HousingController::class,'getDashboardStatuses']);
Route::get('/real-estates',[RealEstateController::class,'getRealEstates']);
Route::get('/menu-list',[MenuController::class,'getMenuList']);
Route::get('/project_housings/{projectId}',[ProjectController::class,'getRooms']);

Route::apiResource('project', ProjectController::class);

Route::get('get_full_projects',[ProjectController::class,"getFullProjects"]);