<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\HousingController;
use App\Http\Controllers\Admin\HousingTypeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Client\HomeController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, "index"])->name('index');
Route::get('/admin/', [AdminHomeController::class, "index"]);

Route::group(['prefix' => 'admin', "as" => "admin."], function () {
    Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');
    Route::resource('/housing_types', HousingTypeController::class);
    Route::resource('/housing', HousingController::class);
    Route::resource('/project', ProjectController::class);

    Route::get('/', [AdminHomeController::class, "index"]);
    Route::get('/menu_management', [MenuController::class, "index"]);
    Route::post('/save_menu', [MenuController::class, "saveMenu"])->name('save.menu');
    Route::get('/get_menu', [MenuController::class, "getMenu"])->name('get.menu');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return "all cleared ...";

});