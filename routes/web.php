<?php

use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\HousingController;
use App\Http\Controllers\Admin\HousingTypeController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\MarketingController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\HousingController as ClientHousingController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Institutional\BrandController;
use App\Http\Controllers\Institutional\DashboardController;
use App\Http\Controllers\Institutional\LoginController;
use App\Http\Controllers\Institutional\ProjectController as InstitutionalProjectController;
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
Route::get('/proje_konut_detayi/{projectSlug}/{id}', [ClientProjectController::class, "projectHousingDetail"])->name('project.housings.detail');
Route::get('/konutlar', [ClientHousingController::class, "list"])->name('housing.list');

Route::get('/admin/login', [AdminLoginController::class, "showLoginForm"])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, "login"])->name('admin.submit.login');
Route::get('/admin/logout', [AdminLoginController::class, "logout"])->name('admin.logout');

Route::group(['prefix' => 'admin', "as" => "admin.", 'middleware' => ['auth', 'admin']], function () {
    Route::middleware(['checkPermission:GetHousingTypeForm'])->group(function () {
        Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');
    });

    // Housing Type Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateHousingType'])->group(function () {
        Route::get('/housing_types/create', [HousingTypeController::class, 'create'])->name('housing_types.create');
        Route::post('/housing_types', [HousingTypeController::class, 'store'])->name('housing_types.store');
    });

    Route::middleware(['checkPermission:GetHousingTypeById'])->group(function () {
        Route::get('/housing_types/{housing_type}/edit', [HousingTypeController::class, 'edit'])->name('housing_types.edit');
    });

    Route::middleware(['checkPermission:UpdateHousingType'])->group(function () {
        Route::put('/housing_types/{housing_type}', [HousingTypeController::class, 'update'])->name('housing_types.update');
    });

    Route::middleware(['checkPermission:GetHousingTypes'])->group(function () {
        Route::get('/housing_types', [HousingTypeController::class, 'index'])->name('housing_types.index');
    });

    Route::middleware(['checkPermission:DeleteHousingType'])->group(function () {
        Route::delete('/housing_types/{housing_type}', [HousingTypeController::class, 'destroy'])->name('housing_types.destroy');
    });

    // Housing Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateHousing'])->group(function () {
        Route::get('/housings/create', [HousingController::class, 'create'])->name('housings.create');
        Route::post('/housings', [HousingController::class, 'store'])->name('housings.store');
    });

    Route::middleware(['checkPermission:GetHousingById'])->group(function () {
        Route::get('/housings/{housing}/edit', [HousingController::class, 'edit'])->name('housings.edit');
    });

    Route::middleware(['checkPermission:UpdateHousing'])->group(function () {
        Route::put('/housings/{housing}', [HousingController::class, 'update'])->name('housings.update');
    });

    Route::middleware(['checkPermission:GetHousings'])->group(function () {
        Route::get('/housings', [HousingController::class, 'index'])->name('housings.index');
    });

    Route::middleware(['checkPermission:DeleteHousing'])->group(function () {
        Route::delete('/housings/{housing}', [HousingController::class, 'destroy'])->name('housings.destroy');
    });

    // Project Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateProject'])->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    });

    Route::middleware(['checkPermission:GetProjectById'])->group(function () {
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    });

    Route::middleware(['checkPermission:UpdateProject'])->group(function () {
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    });

    Route::middleware(['checkPermission:GetProjects'])->group(function () {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    });

    Route::middleware(['checkPermission:DeleteProject'])->group(function () {
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

    // User Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateUser'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

    Route::middleware(['checkPermission:GetUserById'])->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    });

    Route::middleware(['checkPermission:UpdateUser'])->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    Route::middleware(['checkPermission:GetUsers'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });

    Route::middleware(['checkPermission:DeleteUser'])->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Profile Controller Rotasının İzinleri
    Route::middleware(['checkPermission:EditProfile'])->group(function () {
        Route::get('/profile/edit', [ProfileController::class, "edit"])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, "update"])->name('profile.update');
    });

    // ChangePassword Controller Rotasının İzinleri
    Route::middleware(['checkPermission:ChangePassword'])->group(function () {
        Route::get('/password/edit', [ChangePasswordController::class, "edit"])->name('password.edit');
        Route::post('/password/update', [ChangePasswordController::class, "update"])->name('password.update');
    });

    // AdminHomeController Rotalarının İzinleri
    Route::middleware(['checkPermission:ViewDashboard'])->group(function () {
        Route::get('/', [AdminHomeController::class, "index"])->name("index");
    });

    Route::get('/menu_management', [MenuController::class, "index"]);
    Route::post('/save_menu', [MenuController::class, "saveMenu"])->name('save.menu');
    Route::get('/get_menu', [MenuController::class, "getMenu"])->name('get.menu');

    // Rol Oluşturma Sayfasına Erişim Kontrolü (CreateRole izni gerekli)
    Route::middleware(['checkPermission:CreateRole'])->group(function () {
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    });

    Route::middleware(['checkPermission:GetRoleById'])->group(function () {
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    });

    // Rol Düzenleme Sayfasına Erişim Kontrolü (UpdateRole izni gerekli)
    Route::middleware(['checkPermission:UpdateRole'])->group(function () {
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });

    // Rol Listeleme Sayfasına Erişim Kontrolü (GetRoles izni gerekli)
    Route::middleware(['checkPermission:GetRoles'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    });

    // Rol Silme İşlemi için Erişim Kontrolü (DeleteRole izni gerekli)
    Route::middleware(['checkPermission:DeleteRole'])->group(function () {
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // İzin Oluşturma Sayfasına Erişim Kontrolü (CreatePermission izni gerekli)
    Route::middleware(['checkPermission:CreatePermission'])->group(function () {
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    });

    Route::middleware(['checkPermission:GetPermissionById'])->group(function () {
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    });

    // İzin Düzenleme Sayfasına Erişim Kontrolü (UpdatePermission izni gerekli)
    Route::middleware(['checkPermission:UpdatePermission'])->group(function () {
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    });

    // İzin Listeleme Sayfasına Erişim Kontrolü (GetPermissions izni gerekli)
    Route::middleware(['checkPermission:GetPermissions'])->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    });

    // İzin Silme İşlemi için Erişim Kontrolü (DeletePermission izni gerekli)
    Route::middleware(['checkPermission:DeletePermission'])->group(function () {
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    // İzin Grupları Oluşturma Sayfasına Erişim Kontrolü (CreatePermissionGroup izni gerekli)
    Route::middleware(['checkPermission:CreatePermissionGroup'])->group(function () {
        Route::get('/permission_groups/create', [PermissionGroupController::class, 'create'])->name('permission_groups.create');
        Route::post('/permission_groups', [PermissionGroupController::class, 'store'])->name('permission_groups.store');
    });

    // İzin Grubu Düzenleme Sayfasına Erişim Kontrolü (UpdatePermissionGroup izni gerekli)
    Route::middleware(['checkPermission:GetPermissionGroupById'])->group(function () {
        Route::get('/permission_groups/{permission_group}/edit', [PermissionGroupController::class, 'edit'])->name('permission_groups.edit');
    });

    // İzin Grubu Düzenleme Sayfasına Erişim Kontrolü (UpdatePermissionGroup izni gerekli)
    Route::middleware(['checkPermission:UpdatePermissionGroup'])->group(function () {
        Route::put('/permission_groups/{permission_group}', [PermissionGroupController::class, 'update'])->name('permission_groups.update');
    });

    // İzin Grubu Listeleme Sayfasına Erişim Kontrolü (GetPermissionGroups izni gerekli)
    Route::middleware(['checkPermission:GetPermissionGroups'])->group(function () {
        Route::get('/permission_groups', [PermissionGroupController::class, 'index'])->name('permission_groups.index');
    });

    // İzin Grubu Silme İşlemi için Erişim Kontrolü (DeletePermissionGroup izni gerekli)
    Route::middleware(['checkPermission:DeletePermissionGroup'])->group(function () {
        Route::delete('/permission_groups/{permission_group}', [PermissionGroupController::class, 'destroy'])->name('permission_groups.destroy');
    });

    Route::middleware(['checkPermission:CreatePage'])->group(function () {
        Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    });

    Route::middleware(['checkPermission:GetPageById'])->group(function () {
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    });

    Route::middleware(['checkPermission:UpdatePage'])->group(function () {
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    });

    Route::middleware(['checkPermission:GetPages'])->group(function () {
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    });

    Route::middleware(['checkPermission:DeletePage'])->group(function () {
        Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    });
    Route::get('/site-settings', [SiteSettingController::class, 'index'])
        ->name('site-settings.index')
        ->middleware('checkPermission:GetSiteSettings'); // İzin kontrolü

    Route::post('/site-settings/update', [SiteSettingController::class, 'update'])
        ->name('site-settings.update')
        ->middleware('checkPermission:UpdateSiteSetting'); // İzin kontrolü

    Route::post('/site-settings/create', [SiteSettingController::class, 'store'])
        ->name('site-settings.create')
        ->middleware('checkPermission:CreateSiteSetting'); // İzin kontrolü

    Route::post('/site-settings/delete', [SiteSettingController::class, 'destroy'])
        ->name('site-settings.create')
        ->middleware('checkPermission:DeleteSiteSetting'); // İzin kontrolü

    Route::get('/smtp/edit', [SmtpSettingController::class, 'edit'])->name('smtp.edit')->middleware('checkPermission:GetSmtpSettingById');
    Route::put('/smtp/update', [SmtpSettingController::class, 'update'])->name('smtp.update')->middleware('checkPermission:UpdateSmtpSetting');

    Route::get('/marketing/project/marketed', [MarketingController::class, 'marketedProjects'])->name('marketing.projects.marketed');
    Route::get('/marketing/project', [MarketingController::class, 'marketing'])->name('marketing.projects.index');
    Route::post('/marketing/project/setmarketed', [MarketingController::class, 'market'])->name('marketing.projects.setmarketed');
    Route::get('/marketing/project/get', [MarketingController::class, 'getMarketing'])->name('marketing.projects.get');
    Route::post('/marketing/project/store', [MarketingController::class, 'storeMarketing'])->name('marketing.projects.store');

});

Route::group(['prefix' => 'institutional', "as" => "institutional."], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/brands', BrandController::class);
    Route::resource('/projects', InstitutionalProjectController::class);
    Route::get('/get_counties', [InstitutionalProjectController::class,"getCounties"])->name('get.counties');
    
});
