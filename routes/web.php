<?php

use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\HousingController;
use App\Http\Controllers\Admin\HousingStatusController;
use App\Http\Controllers\Admin\HousingTypeController;
use App\Http\Controllers\Admin\InfoController;
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
use App\Http\Controllers\Admin\SocialMediaIconController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\ClientPanel\ChangePasswordController as ClientPanelChangePasswordController;
use App\Http\Controllers\ClientPanel\DashboardController as ClientPanelDashboardController;
use App\Http\Controllers\ClientPanel\ProfileController as ClientPanelProfileController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\HousingController as ClientHousingController;
use App\Http\Controllers\Client\InstitutionalController;
use App\Http\Controllers\Client\LoginController as ClientLoginController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Client\PageController as ClientPageController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Institutional\BrandController;
use App\Http\Controllers\Institutional\BuyController;
use App\Http\Controllers\Institutional\ChangePasswordController as InstitutionalChangePasswordController;
use App\Http\Controllers\Institutional\DashboardController;
use App\Http\Controllers\Institutional\LoginController;
use App\Http\Controllers\Institutional\ProfileController as InstitutionalProfileController;
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
Route::get('/instituional/search', [InstituionalController::class, 'search'])->name('instituional.search');

Route::get('/proje/{slug}', [ClientProjectController::class, "index"])->name('project.detail');
Route::get('/proje/{slug}/detay', [ClientProjectController::class, "detail"])->name('project.housing.detail');
Route::get('/magaza/{slug}/profil', [InstitutionalController::class, "profile"])->name('instituional.profile');
Route::get('/magaza/{slug}/projeler', [InstitutionalController::class, "projectDetails"])->name('instituional.projects.detail');

Route::get('/marka_projeleri/{id}', [ClientProjectController::class, "brandProjects"])->name('brand.projects');
Route::get('/projeler', [ClientProjectController::class, "projectList"])->name('project.list');
Route::get('/proje_konut_detayi/{projectSlug}/{id}', [ClientProjectController::class, "projectHousingDetail"])->name('project.housings.detail');
Route::get('/konutlar', [ClientHousingController::class, "list"])->name('housing.list');
Route::get('sayfa/{slug}', [ClientPageController::class, 'index'])->name('page.show');
Route::post('add_to_cart/', [CartController::class, 'add'])->name('add.to.cart');
Route::get('sepetim', [CartController::class, 'index'])->name('cart');
Route::get('favoriler', [FavoriteController::class, 'showFavorites'])->name('favorites');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('client.remove.from.cart');
Route::post('/add-housing-to-favorites/{id}', [FavoriteController::class, "addHousingToFavorites"])->name('add.housing.to.favorites');
Route::get('/get-housing-favorite-status/{id}', [FavoriteController::class, "getHousingFavoriteStatus"])->name('get.housing.favorite.status');

Route::get('{property}-projeler', [ClientProjectController::class, 'propertyProjects'])->name('propertyProjects');

Route::get('/admin/login', [AdminLoginController::class, "showLoginForm"])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, "login"])->name('admin.submit.login');
Route::get('/admin/logout', [AdminLoginController::class, "logout"])->name('admin.logout');

Route::get('/giris-yap', [ClientLoginController::class, "showLoginForm"])->name('client.login');
Route::post('/login', [ClientLoginController::class, "login"])->name('client.submit.login');
Route::post('/kayit-ol', [RegisterController::class, "register"])->name('client.submit.register');
Route::get('/cikis-yap', [ClientLoginController::class, "logout"])->name('client.logout');

Route::group(['prefix' => 'admin', "as" => "admin.", 'middleware' => ['admin']], function () {

    Route::get('info/contact', [InfoController::class, 'contact'])->name('info.contact.index');
    Route::post('info/setContact', [InfoController::class, 'contactSetOrEdit'])->name('info.contact.set');

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
        Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');
    });

    Route::middleware(['checkPermission:GetHousingStatuses'])->group(function () {
        Route::get('/housing_statuses', [HousingStatusController::class, 'index'])->name('housing_statuses.index');
    });

    Route::middleware(['checkPermission:EditHousingStatuses'])->group(function () {
        Route::get('/housing_status/{id}/edit', [HousingStatusController::class, 'edit'])->name('housing_statuses.edit');
        Route::post('/housing_status/{id}/edit', [HousingStatusController::class, 'update'])->name('housing_statuses.update');
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

    Route::get('/menu_management', [MenuController::class, "index"])->name("menu_management");
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
    Route::get('info/contact', [InfoController::class, 'contact'])->name('info.contact.index');
    Route::post('info/setContact', [InfoController::class, 'contactSetOrEdit'])->name('info.contact.set');

    Route::get('/marketing/project/marketed', [MarketingController::class, 'marketedProjects'])->name('marketing.projects.marketed');
    Route::get('/marketing/project', [MarketingController::class, 'marketing'])->name('marketing.projects.index');
    Route::post('/marketing/project/setmarketed', [MarketingController::class, 'market'])->name('marketing.projects.setmarketed');
    Route::get('/marketing/project/get', [MarketingController::class, 'getMarketing'])->name('marketing.projects.get');
    Route::post('/marketing/project/store', [MarketingController::class, 'storeMarketing'])->name('marketing.projects.store');

    Route::middleware(['checkPermission:DeleteFooterLink'])->group(function () {
        Route::delete('/footer_links/{footer_link}', [FooterLinkController::class, 'destroy'])->name('footer_links.destroy');
    });

    Route::middleware(['checkPermission:CreateFooterLink'])->group(function () {
        Route::get('/footer_links/create', [FooterLinkController::class, 'create'])->name('footer_links.create');
        Route::post('/footer_links', [FooterLinkController::class, 'store'])->name('footer_links.store');
    });

    Route::middleware(['checkPermission:GetFooterLinkById'])->group(function () {
        Route::get('/footer_links/{footer_link}/edit', [FooterLinkController::class, 'edit'])->name('footer_links.edit');
    });

    Route::middleware(['checkPermission:UpdateFooterLink'])->group(function () {
        Route::put('/footer_links/{footer_link}', [FooterLinkController::class, 'update'])->name('footer_links.update');
    });

    Route::middleware(['checkPermission:GetFooterLinks'])->group(function () {
        Route::get('/footer_links', [FooterLinkController::class, 'index'])->name('footer_links.index');
    });

    Route::middleware(['checkPermission:DeleteSocialMediaIcon'])->group(function () {
        Route::delete('/social_media_icons/{social_media_icon}', [SocialMediaIconController::class, 'destroy'])->name('social_media_icons.destroy');
    });

    Route::middleware(['checkPermission:CreateSocialMediaIcon'])->group(function () {
        Route::get('/social_media_icons/create', [SocialMediaIconController::class, 'create'])->name('social_media_icons.create');
        Route::post('/social_media_icons', [SocialMediaIconController::class, 'store'])->name('social_media_icons.store');
    });

    Route::middleware(['checkPermission:GetSocialMediaIconById'])->group(function () {
        Route::get('/social_media_icons/{social_media_icon}/edit', [SocialMediaIconController::class, 'edit'])->name('social_media_icons.edit');
    });

    Route::middleware(['checkPermission:UpdateSocialMediaIcon'])->group(function () {
        Route::put('/social_media_icons/{social_media_icon}', [SocialMediaIconController::class, 'update'])->name('social_media_icons.update');
    });

    Route::middleware(['checkPermission:GetSocialMediaIcons'])->group(function () {
        Route::get('/social_media_icons', [SocialMediaIconController::class, 'index'])->name('social_media_icons.index');
    });

});


Route::get('/institutional/login', [LoginController::class, 'index'])->name('institutional.login');
Route::post('/institutional/login', [LoginController::class, 'login'])->name('institutional.login.post');

Route::group(['prefix' => 'institutional', "as" => "institutional.", 'middleware' => ['institutional']], function () {

    // Profile Controller Rotasının İzinleri
    Route::middleware(['checkPermission:EditProfile'])->group(function () {
        Route::get('/profile/edit', [InstitutionalProfileController::class, "edit"])->name('profile.edit');
        Route::put('/profile/update', [InstitutionalProfileController::class, "update"])->name('profile.update');
    });

    Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');

    // ChangePassword Controller Rotasının İzinleri
    Route::middleware(['checkPermission:ChangePassword'])->group(function () {
        Route::get('/password/edit', [InstitutionalChangePasswordController::class, "edit"])->name('password.edit');
        Route::post('/password/update', [InstitutionalChangePasswordController::class, "update"])->name('password.update');
    });

    // AdminHomeController Rotalarının İzinleri
    Route::middleware(['checkPermission:ViewDashboard'])->group(function () {
        Route::get('/', [DashboardController::class, "index"])->name("index");
    });

    Route::resource('/brands', BrandController::class);
    Route::resource('/projects', InstitutionalProjectController::class);
    Route::get('/project_stand_out/{project_id}', [InstitutionalProjectController::class,"standOut"])->name('project.stand.out');
    Route::get('/get_stand_out_prices', [InstitutionalProjectController::class,"pricingList"])->name('project.pricing.list');
    Route::get('/get_counties', [InstitutionalProjectController::class, "getCounties"])->name('get.counties');
    Route::post('/buy_order', [BuyController::class, "buyOrder"])->name('buy.order');
    Route::middleware(['checkPermission:NewProjectImage'])->group(function () {
        Route::post('/new_project_file/{project_id}', [InstitutionalProjectController::class, "newProjectImage"])->name('new.project.image');
        Route::post('/delete_project_image/{project_id}/{filename}', [InstitutionalProjectController::class, "deleteProjectImage"])->name('delete.project.image');
        Route::post('/remove_project_housing_file', [InstitutionalProjectController::class, "removeProjectHousingFile"])->name('remove.project.housing.image');
        Route::post('/add_project_housing_file', [InstitutionalProjectController::class, "addProjectHousingFile"])->name('add.project.housing.image');
    });
});

Route::group(['prefix' => 'hesabim', "as" => "client.", 'middleware' => ['client']], function () {

    // Profile Controller Rotasının İzinleri
    Route::middleware(['checkPermission:EditProfile'])->group(function () {
        Route::get('/profili-guncelle', [ClientPanelProfileController::class, "edit"])->name('profile.edit');
        Route::put('/profile/update', [ClientPanelProfileController::class, "update"])->name('profile.update');
    });

    // ChangePassword Controller Rotasının İzinleri
    Route::middleware(['checkPermission:ChangePassword'])->group(function () {
        Route::get('/sifreyi-degistir', [ClientPanelChangePasswordController::class, "edit"])->name('password.edit');
        Route::post('/password/update', [ClientPanelChangePasswordController::class, "update"])->name('password.update');
    });

    // AdminHomeController Rotalarının İzinleri
    Route::middleware(['checkPermission:ViewDashboard'])->group(function () {
        Route::get('/', [ClientPanelDashboardController::class, "index"])->name("index");
        Route::post('/order',[OrderController::class,'createOrder'])->name('create.order');
        Route::get('/getOrders',[OrderController::class,'getOrders']);
    });

    // User Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateUser'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

});
