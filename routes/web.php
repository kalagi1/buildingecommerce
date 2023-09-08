<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\HousingController;
use App\Http\Controllers\Admin\HousingTypeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\HousingController as ClientHousingController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Institutional\BrandController;
use App\Http\Controllers\Institutional\DashboardController;
use App\Http\Controllers\Institutional\LoginController;
use App\Http\Controllers\Institutional\ProjectController as InstitutionalProjectController;
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
Route::get('/admin', [AdminHomeController::class, "index"]);
Route::get('/housing/{id}', [ClientHousingController::class, "show"])->name('housing.show');
Route::get('/admin', [AdminHomeController::class, "index"]);
Route::get('/project/{slug}', [ClientProjectController::class, "index"])->name('project.detail');
Route::get('/marka_projeleri/{id}', [ClientProjectController::class, "brandProjects"])->name('brand.projects');
Route::get('/projeler', [ClientProjectController::class, "projectList"])->name('project.list');

Route::group(['prefix' => 'admin', "as" => "admin."], function () {
    Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');
    Route::resource('/housing_types', HousingTypeController::class);
    Route::resource('/housing', HousingController::class);
    Route::resource('/project', ProjectController::class);
    Route::resource('/users', UserController::class);

    Route::get('/', [AdminHomeController::class, "index"]);
    Route::get('/menu_management', [MenuController::class, "index"]);
    Route::post('/save_menu', [MenuController::class, "saveMenu"])->name('save.menu');
    Route::get('/get_menu', [MenuController::class, "getMenu"])->name('get.menu');

    Route::resource('/roles', RoleController::class);
    Route::delete('/roles/bulkDelete', [RoleController::class, "bulkDelete"])->name('roles.bulkDelete');
    Route::resource('/pages', PageController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/permission_groups', PermissionGroupController::class);


});


Route::group(['prefix' => 'institutional', "as" => "institutional."], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/brands', BrandController::class);
    Route::resource('/project', InstitutionalProjectController::class);
    
});
