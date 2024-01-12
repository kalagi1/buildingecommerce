<?php

use App\Http\Controllers\Admin\AdBannerController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\DopingOrderController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\HousingController;
use App\Http\Controllers\Admin\HousingStatusController;
use App\Http\Controllers\Admin\HousingStatusParentController;
use App\Http\Controllers\Admin\HousingTypeController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\MarketingController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentTempController as AdminPaymentTempController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\SocialMediaIconController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\ClientPanel\ChangePasswordController as ClientPanelChangePasswordController;
use App\Http\Controllers\ClientPanel\DashboardController as ClientPanelDashboardController;
use App\Http\Controllers\ClientPanel\ProfileController as ClientPanelProfileController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CollectionController;
use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\CountyController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\HousingController as ClientHousingController;
use App\Http\Controllers\Client\InstitutionalController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\LoginController as ClientLoginController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\PageController as ClientPageController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Client\RealEstateController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\SharerController;
use App\Http\Controllers\Client\SupportChatController;
use App\Http\Controllers\Client\TaxOfficeController;
use App\Http\Controllers\Client\VerifyController;
use App\Http\Controllers\Institutional\BankAccountController as InstitutionalBankAccountController;
use App\Http\Controllers\Institutional\BrandController;
use App\Http\Controllers\Institutional\BuyController;
use App\Http\Controllers\Institutional\ChangePasswordController as InstitutionalChangePasswordController;
use App\Http\Controllers\Institutional\DashboardController;
use App\Http\Controllers\Institutional\HousingController as InstitutionalHousingController;
use App\Http\Controllers\Institutional\InvoiceController as InstitutionalInvoiceController;
use App\Http\Controllers\Institutional\LoginController;
use App\Http\Controllers\Institutional\OfferController as InstitutionalOfferController;
use App\Http\Controllers\Institutional\PaymentTempController;
use App\Http\Controllers\Institutional\ProfileController as InstitutionalProfileController;
use App\Http\Controllers\Institutional\ProjectController as InstitutionalProjectController;
use App\Http\Controllers\Institutional\RoleController as InstitutionalRoleController;
use App\Http\Controllers\Institutional\SinglePriceController;
use App\Http\Controllers\Institutional\StoreBannerController;
use App\Http\Controllers\Institutional\TempOrderController;
use App\Http\Controllers\Institutional\UserController as InstitutionalUserController;
use App\Http\Controllers\NotificationController as ControllersNotificationController;
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
Route::get('/sat-kirala-form', [RealEstateController::class, "index"])->name('real.estate.index');
Route::get('/sat-kirala', [HomeController::class, "satKirala"])->name('satKirala');
Route::get('/admin', [AdminHomeController::class, "index"]);
Route::get('/ikinci-el-konutlar/{id}', [ClientHousingController::class, "show"])->name('housing.show');
Route::get('/admin', [AdminHomeController::class, "index"]);
Route::get('/instituional/search', [InstitutionalController::class, 'search'])->name('instituional.search');
Route::get('/marka/{id}', [ClientProjectController::class, "brandProjects"])->name('brand.projects');
Route::post('notification/read', [NotificationController::class, "markAsRead"])->name('notification.read');
Route::post('/rezervasyon-yap', [ReservationController::class,"store"])->name('reservation.store');
Route::get('/koleksiyonlarim', [SharerController::class,"index"])->name('sharer.index');
Route::get('/koleksiyonlarim/{id}', [SharerController::class,"showLinks"])->name('sharer.links.index');

Route::get('/paylasimci-paneli', [SharerController::class,"sharerPanel"])->name('sharer.panel');
Route::get('/paylasimci-paneli/{username}', [SharerController::class,"sharerPanelByAnotherUser"])->name('sharer.panel.another.user');
Route::get('/search/results',[HomeController::class, "searchResults"])->name('search.results');

Route::get('get-search-list', [HomeController::class, 'getSearchList'])->name('get-search-list');
Route::post('get-rendered-secondhandhousings', [HomeController::class, "getRenderedSecondhandHousings"])->name("get-rendered-secondhandhousings");
Route::post('get-rendered-projects', [HomeController::class, "getRenderedProjects"])->name("get-rendered-projects");

Route::middleware('auth')->group(function () {
    Route::post('/housing/{id}/send-comment', [ClientHousingController::class, "sendComment"])->name('housing.send-comment');
});

Route::get('/proje/{slug}', [ClientProjectController::class, "index"])->name('project.detail');
Route::get('/proje_ajax/{slug}', [ClientProjectController::class, "ajaxIndex"])->name('project.detail.ajax');
Route::get('/project_get_housing_by_start_and_end/{project_id}/{housing_order}', [ClientProjectController::class, "getProjectHousingByStartAndEnd"])->name('project.get.housings.by.start.and.end');
Route::get('/project_payment_plan', [ClientProjectController::class, "projectPaymentPlan"])->name('get.housing.payment.plan');
Route::get('/proje/detay/{slug}', [ClientProjectController::class, "detail"])->name('project.housing.detail');
Route::get('/magaza/{slug}', [InstitutionalController::class, "dashboard"])->name('instituional.dashboard');
Route::post('/magaza/{slug}', [InstitutionalController::class, "getFilterInstitutionalData"])->name('instituional.dashboard.filter');

Route::get('/magaza/{slug}/profil', [InstitutionalController::class, "profile"])->name('instituional.profile');
Route::get('/magaza/{slug}/proje-ilanlari', [InstitutionalController::class, "projectDetails"])->name('instituional.projects.detail');
Route::get('/magaza/{slug}/emlak-ilanlari', [InstitutionalController::class, "housingList"])->name('instituional.housings');
Route::get('/projeler', [ClientProjectController::class, "projectList"])->name('project.list');

Route::get('/get-counties/{city}', [CountyController::class, "getCounties"])->name("getCounties");
Route::get('/get-counties-for-client/{city}', [CountyController::class, "getCountiesForClient"])->name("getCountiesForClient");
Route::get('/get-neighborhoods-for-client/{county}', [CountyController::class, "getNeighborhoodsForClient"])->name("getNeighborhoodsForClient");
Route::get('/get-neighborhoods/{neighborhood}', [CountyController::class, "getNeighborhoods"])->name("getNeighborhoods");

Route::get('/get-tax-office/{taxOffice}', [TaxOfficeController::class, "getTaxOffice"])->name("getTaxOffice");
Route::get('/get-tax-office/{taxOffice}', [TaxOfficeController::class, "getTaxOffice"])->name("getTaxOffice");

Route::get('/proje_konut_detayi/{projectSlug}/{id}', [ClientProjectController::class, "projectHousingDetail"])->name('project.housings.detail');
Route::get('/proje_konut_detayi_ajax/{slug}/{id}', [ClientProjectController::class, "projectHousingDetailAjax"])->name('project.housings.detail.ajax');
Route::get('/konutlar', [ClientHousingController::class, "list"])->name('housing.list');
Route::get('/al-sat-acil', [ClientHousingController::class, "alert"])->name('housing.alert');

Route::get('sayfa/{slug}', [ClientPageController::class, 'index'])->name('page.show');
Route::post('add_to_cart/', [CartController::class, 'add'])->name('add.to.cart');
Route::post('add_to_project_cart/', [CartController::class, 'addProject'])->name('add.to.project.cart');

Route::get('sepetim', [CartController::class, 'index'])->name('cart');
Route::get('favoriler', [FavoriteController::class, 'showFavorites'])->name('favorites');

Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('client.remove.from.cart');

Route::post('/add-project-housing-to-favorites/{id}', [FavoriteController::class, "addProjectHousingToFavorites"])->name('add.project.housing.to.favorites');
Route::post('/get-project-housing-favorite-status', [FavoriteController::class, "getProjectHousingFavoriteStatus"])->name('get.project.housing.favorite.status');

Route::post('/add-housing-to-favorites/{id}', [FavoriteController::class, "addHousingToFavorites"])->name('add.housing.to.favorites');
Route::get('/get-housing-favorite-status/{id}', [FavoriteController::class, "getHousingFavoriteStatus"])->name('get.housing.favorite.status');

Route::get('{property}-projeler', [ClientProjectController::class, 'propertyProjects'])->name('propertyProjects');

Route::get('/admin/login', [AdminLoginController::class, "showLoginForm"])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, "login"])->name('admin.submit.login');
Route::get('/admin/logout', [AdminLoginController::class, "logout"])->name('admin.logout');

Route::middleware('guest')->group(function () {
    Route::get('/giris-yap', [ClientLoginController::class, "showLoginForm"])->name('client.login');
    Route::post('/login', [ClientLoginController::class, "login"])->name('client.submit.login');
    Route::post('/kayit-ol', [RegisterController::class, "register"])->name('client.submit.register');

});
Route::get('/getCollections', [CollectionController::class, 'getCollections']);
Route::resource('collections', CollectionController::class);

Route::get('/login_with_google', [ClientLoginController::class, "googleLogin"])->name('client.google.login');
Route::get('/login-with-google', [ClientLoginController::class, "redirectGoogle"])->name('redirect.google.login');

Route::middleware('auth')->group(function () {
    Route::get('/cikis-yap', [ClientLoginController::class, "logout"])->name('client.logout');
});

Route::get('/auth/google', [AuthLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/auth/facebook', [AuthLoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [AuthLoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

Route::get('/verify-email/{token}', [VerifyController::class, "verifyEmail"])->name('verify.email');

// Şifre sıfırlama linkini gösterme ve isteme sayfası
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

// Şifre sıfırlama linkini e-posta ile gönderme işlemi
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// Yeni şifre belirleme sayfası
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Yeni şifreyi kaydetme işlemi
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/institutional/login', [LoginController::class, 'index'])->name('institutional.login');
Route::post('/institutional/login', [LoginController::class, 'login'])->name('institutional.login.post');

Route::post('/mark-notification-as-read/{id}', [InfoController::class, "markAsRead"]);

Route::group(['prefix' => 'admin', "as" => "admin.", 'middleware' => ['admin']], function () {
    Route::put('/users/{user}/block', [UserController::class, 'blockUser'])->name('users.block');
    Route::get('/messages', [UserController::class, 'messages'])->name('messages');
    Route::post('/messages/store', [SupportChatController::class, 'adminStore'])->name('messages.store');
    Route::post('/upload-endpoint', [UserController::class, "upload"])->name("ckeditor.upload");

    Route::get('/notification-history', [InfoController::class, 'notificationHistory'])->name('notification-history');

    Route::get('info/contact', [InfoController::class, 'contact'])->name('info.contact.index');
    Route::post('info/setContact', [InfoController::class, 'contactSetOrEdit'])->name('info.contact.set');

    Route::get('set-readed-dn/{dn}', [InfoController::class, 'setReadedDn'])->name('set-readed-dn');

    Route::middleware(['checkPermission:showCorporateStatus'])->group(function () {
        Route::get('get/tax-document/{user}', [UserController::class, 'getTaxDocument'])->name('get.tax-document');
        Route::get('get/record-document/{user}', [UserController::class, 'getRecordDocument'])->name('get.record-document');
        Route::get('get/identity-document/{user}', [UserController::class, 'getIdentityDocument'])->name('get.identity-document');
        Route::get('get/company-document/{user}', [UserController::class, 'getCompanyDocument'])->name('get.company-document');
        Route::post('update-corporate-status/{user}', [UserController::class, 'updateCorporateStatus'])->name('update-corporate-status');
        Route::get('show-corporate-account/{user}', [UserController::class, 'showCorporateAccount'])->name('user.show-corporate-account');
    });

    Route::middleware(['checkPermission:HousingStatusParent'])->group(function () {

        Route::get('/get_housing_type_childrens/{parentSlug}', [InstitutionalProjectController::class, "getHousingTypeChildren"])->name('get.housing.type.childrens');
        Route::get('housing_status_parent_management', [HousingStatusParentController::class, 'index'])->name('housing.status.parent.management');
        Route::post('new_housing_status_parent', [HousingStatusParentController::class, 'store'])->name('new.housing.type.parent');
        Route::post('delete_housing_status_parent', [HousingStatusParentController::class, 'destroy'])->name('delete.housing.type.parent');
        Route::get('get_housing_type_parent_connections', [HousingStatusParentController::class, 'getHousingParentConnections'])->name('get.housing.type.parent.connections');
        Route::post('add_housing_parent_connection', [HousingStatusParentController::class, 'addHousingParentConnection'])->name('add.housing.parent.connection');
    });

    Route::middleware(['checkPermission:CreateAdBanner'])->group(function () {
        Route::get('/ad-banners/create', [AdBannerController::class, 'create'])->name('adBanners.create');
        Route::post('/ad-banners', [AdBannerController::class, 'store'])->name('adBanners.store');
    });

    Route::middleware(['checkPermission:GetAdBannerById'])->group(function () {
        Route::get('/ad-banners/{adBanner}/edit', [AdBannerController::class, 'edit'])->name('adBanners.edit');
    });

    Route::middleware(['checkPermission:UpdateAdBanner'])->group(function () {
        Route::put('/ad-banners/{adBanner}', [AdBannerController::class, 'update'])->name('adBanners.update');
    });

    Route::middleware(['checkPermission:GetAdBanners'])->group(function () {
        Route::get('/ad-banners', [AdBannerController::class, 'index'])->name('adBanners.index');
    });

    Route::middleware(['checkPermission:DeleteAdBanner'])->group(function () {
        Route::delete('/ad-banners/{adBanner}', [AdBannerController::class, 'destroy'])->name('adBanners.destroy');
    });

    Route::middleware(['checkPermission:GetOrders'])->group(function () {
        Route::get('/orders', [AdminHomeController::class, 'getOrders'])->name('orders');
        Route::get('/reservations', [AdminHomeController::class, 'getReservations'])->name('reservations');

        Route::get('/package-orders', [AdminHomeController::class, 'getPackageOrders'])->name('packageOrders');

        Route::get('/order/approve/{cartOrder}', [AdminHomeController::class, 'approveOrder'])->name('approve-order');
        Route::get('/order/unapprove/{cartOrder}', [AdminHomeController::class, 'unapproveOrder'])->name('unapprove-order');


        Route::get('/reservation/approve/{reservation}', [AdminHomeController::class, 'approveReservation'])->name('approve-reservation');
        Route::get('/reservation/unapprove/{reservation}', [AdminHomeController::class, 'unapproveReservation'])->name('unapprove-reservation');

        Route::get('/order/approve/package/{userPlan}', [AdminHomeController::class, 'approvePackageOrder'])->name('approve-package-order');
        Route::get('/order/unapprove/package/{userPlan}', [AdminHomeController::class, 'unapprovePackageOrder'])->name('unapprove-package-order');
    });

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
        Route::post('/housings/{housing}/set_status', [HousingController::class, 'setStatus'])->name('housings.set.status');
        Route::get('/housings/{housing}/set_status', [HousingController::class, 'setStatusGet'])->name('housings.set.status.get');
        Route::get('/housings/{housing}/edit', [HousingController::class, 'edit'])->name('housings.edit');
        Route::get('/housings/{housing}/detail', [HousingController::class, 'detail'])->name('housings.detail');
        Route::get('/housings/{housingId}/logs', [HousingController::class, 'logs'])->name('housing.logs');
    });

    Route::middleware(['checkPermission:UpdateHousing'])->group(function () {
        Route::put('/housings/{housing}', [HousingController::class, 'update'])->name('housings.update');
    });

    Route::middleware(['checkPermission:GetHousings'])->group(function () {
        Route::get('/housings', [HousingController::class, 'index'])->name('housings.index');
    });
    Route::middleware(['checkPermission:GetHousingComments'])->group(function () {
        Route::get('/housing/comments', [HousingController::class, 'comments'])->name('housings.comments');
        Route::get('/housing/comment/approve/{id}', [HousingController::class, 'approveComment'])->name('housings.approve');
        Route::get('/housing/comment/unapprove/{id}', [HousingController::class, 'unapproveComment'])->name('housings.unapprove');
    });

    Route::middleware(['checkPermission:DeleteHousing'])->group(function () {
        Route::delete('/housings/{housing}', [HousingController::class, 'destroy'])->name('housings.destroy');
    });

    // Project Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateProject'])->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.index.store.old');
        Route::get('/{project_id}/logs', [ProjectController::class, 'logs'])->name('projects.logs');
        Route::get('/project/{projectId}', [ProjectController::class, 'detail'])->name('projects.detail');
        Route::post('/project/status_change/{projectId}', [ProjectController::class, 'setStatus'])->name('project.set.status');
        Route::get('/project/status_change/{projectId}', [ProjectController::class, 'setStatusGet'])->name('project.set.status.get');
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
        ->name('site-settings.delete')
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

    Route::middleware(['checkPermission:DeleteSlider'])->group(function () {
        Route::delete('/sliders/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');
        Route::delete('/footer-sliders/{slider}', [SliderController::class, 'footerDestroy'])->name('footer-sliders.destroy');
    });

    Route::middleware(['checkPermission:CreateSlider'])->group(function () {
        Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create');
        Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');

        Route::get('/footer-sliders/create', [SliderController::class, 'footerCreate'])->name('footer-sliders.create');
        Route::post('/footer-sliders', [SliderController::class, 'footerStore'])->name('footer-sliders.store');
    });

    Route::middleware(['checkPermission:GetSliderById'])->group(function () {
        Route::get('/sliders/{slider}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
        Route::get('/footer-sliders/{slider}/edit', [SliderController::class, 'footerEdit'])->name('footer-sliders.edit');
    });

    Route::middleware(['checkPermission:UpdateSlider'])->group(function () {
        Route::put('/sliders/{slider}', [SliderController::class, 'update'])->name('sliders.update');
        Route::put('/footer-sliders/{slider}', [SliderController::class, 'footerUpdate'])->name('footer-sliders.update');
    });

    Route::middleware(['checkPermission:GetSliders'])->group(function () {
        Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
        Route::get('/footer-sliders', [SliderController::class, 'footerIndex'])->name('footer-sliders.index');
    });

    Route::middleware(['checkPermission:DeleteEmailTemplate'])->group(function () {
        Route::delete('/email-templates/{email_template}', [EmailTemplateController::class, 'destroy'])->name('email-templates.destroy');
    });

    Route::middleware(['checkPermission:CreateEmailTemplate'])->group(function () {
        Route::get('/email-templates/create', [EmailTemplateController::class, 'create'])->name('email-templates.create');
        Route::post('/email-templates', [EmailTemplateController::class, 'store'])->name('email-templates.store');
    });

    Route::middleware(['checkPermission:GetEmailTemplateById'])->group(function () {
        Route::get('/email-templates/{email_template}/edit', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
    });

    Route::middleware(['checkPermission:UpdateEmailTemplate'])->group(function () {
        Route::put('/email-templates/{email_template}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
    });

    Route::middleware(['checkPermission:GetEmailTemplates'])->group(function () {
        Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
    });

    Route::middleware(['checkPermission:CreateSubscriptionPlan'])->group(function () {
        Route::get('/subscription-plans/create', [SubscriptionPlanController::class, 'create'])->name('subscriptionPlans.create');
        Route::post('/subscription-plans', [SubscriptionPlanController::class, 'store'])->name('subscriptionPlans.store');
    });

    Route::middleware(['checkPermission:GetSubscriptionPlanById'])->group(function () {
        Route::get('/subscription-plans/{subscriptionPlan}/edit', [SubscriptionPlanController::class, 'edit'])->name('subscriptionPlans.edit');
    });

    Route::middleware(['checkPermission:UpdateSubscriptionPlan'])->group(function () {
        Route::put('/subscription-plans/{subscriptionPlan}', [SubscriptionPlanController::class, 'update'])->name('subscriptionPlans.update');
    });

    Route::middleware(['checkPermission:GetSubscriptionPlans'])->group(function () {
        Route::get('/subscription-plans', [SubscriptionPlanController::class, 'index'])->name('subscriptionPlans.index');
    });

    Route::middleware(['checkPermission:DeleteSubscriptionPlan'])->group(function () {
        Route::delete('/subscription-plans/{subscriptionPlan}', [SubscriptionPlanController::class, 'destroy'])->name('subscriptionPlans.destroy');
    });

    Route::middleware(['checkPermission:CreateBankAccount'])->group(function () {
        Route::get('/bank_account/create', [BankAccountController::class, 'create'])->name('bank_account.create');
        Route::post('/bank_account/create', [BankAccountController::class, 'store'])->name('bank_account.store');
    });

    Route::middleware(['checkPermission:GetBankAccounts'])->group(function () {
        Route::get('/bank_accounts', [BankAccountController::class, 'index'])->name('bank_account.index');
    });

    Route::middleware(['checkPermission:CreateBankAccount'])->group(function () {
        Route::get('/bank_account/create', [BankAccountController::class, 'create'])->name('bank_account.create');
        Route::post('/bank_account/create', [BankAccountController::class, 'store'])->name('bank_account.store');
    });

    Route::middleware(['checkPermission:UpdateBankAccount'])->group(function () {
        Route::get('/bank_account/{id}/edit', [BankAccountController::class, 'edit'])->name('bank_account.edit');
        Route::post('/bank_account/{id}/update', [BankAccountController::class, 'update'])->name('bank_account.update');
    });

    Route::middleware(['checkPermission:DeleteBankAccount'])->group(function () {
        Route::delete('/bank_account/{id}/delete', [BankAccountController::class, 'destroy'])->name('bank_account.destroy');
    });

    Route::middleware(['checkPermission:PaymentTempList'])->group(function () {
        Route::get('/payment_list', [AdminPaymentTempController::class, 'index'])->name('payment.temp.list');
    });

    Route::middleware(['checkPermission:PaymentTempStatusChange'])->group(function () {
        Route::post('/payment_temp_change_status/{id}', [AdminPaymentTempController::class, 'changeStatus'])->name('payment.temp.change.status');
    });

    Route::middleware(['checkPermission:DopingOrders'])->group(function () {
        Route::get('/doping_orders', [DopingOrderController::class, 'index'])->name('doping.orders');
        Route::get('/apply_doping_orders/{dopingId}', [DopingOrderController::class, 'apply'])->name('apply.doping.order');
        Route::get('/unapply_doping_orders/{dopingId}', [DopingOrderController::class, 'unapply'])->name('unapply.doping.order');
    });

});

Route::group(['prefix' => 'institutional', "as" => "institutional.", 'middleware' => ['institutional', 'checkCorporateAccount']], function () {
    Route::post('/generate-pdf', [InvoiceController::class, "generatePDF"]);
    Route::get('/orders', [DashboardController::class, 'getOrders'])->name('orders');
    Route::get('/reservations', [DashboardController::class, 'getReservations'])->name('reservations');

    Route::get('/projects/{project_id}/housings', [InstitutionalProjectController::class, 'housings'])->name('projects.housings');
    Route::post('/set_single_data/{project_id}', [InstitutionalProjectController::class, 'setSingleHousingData'])->name('projects.set.single.data');
    Route::post('/set_single_data_image/{project_id}', [InstitutionalProjectController::class, 'setSingleHousingImage'])->name('projects.set.single.image');

    Route::get('verification', [DashboardController::class, 'corporateAccountVerification'])->name('corporate-account-verification');
    Route::post('verify-account', [DashboardController::class, 'verifyAccount'])->name('verify-account');

    Route::get('get/tax-document', [InstitutionalUserController::class, 'getTaxDocument'])->name('get.tax-document');
    Route::get('get/record-document', [InstitutionalUserController::class, 'getRecordDocument'])->name('get.record-document');
    Route::get('get/identity-document', [InstitutionalUserController::class, 'getIdentityDocument'])->name('get.identity-document');
    Route::get('get/company-document', [InstitutionalUserController::class, 'getCompanyDocument'])->name('get.company-document');

    // Offers - Kampanyalar
    Route::middleware(['checkPermission:CreateOffer'])->group(function () {
        Route::get('/offers/create', [InstitutionalOfferController::class, 'create'])->name('offers.create');
        Route::post('/offers', [InstitutionalOfferController::class, 'store'])->name('offers.store');
        Route::get('/offers/get-project-housings', [InstitutionalOfferController::class, 'getProjectHousingList'])->name('offers.get-project-housings');
    });

    Route::middleware(['checkPermission:GetOfferById'])->group(function () {
        Route::get('/offers/{offer}/edit', [InstitutionalOfferController::class, 'edit'])->name('offers.edit');
    });

    Route::middleware(['checkPermission:UpdateOffer'])->group(function () {
        Route::put('/offers/{offer}', [InstitutionalOfferController::class, 'update'])->name('offers.update');
    });

    Route::middleware(['checkPermission:ChoiseAdvertiseType'])->group(function () {
        Route::get('/ilan-tipi-sec', [TempOrderController::class, "choiseAdvertiseType"])->name('choise.advertise.type');
    });

    Route::middleware(['checkPermission:TempOrder'])->group(function () {
        Route::post('/end_project_copy_item_image', [TempOrderController::class, "copyItemImage"])->name('copy.item.image');
        Route::post('/update_image_order_temp_update', [TempOrderController::class, 'updateImageOrders'])->name('update.image.order.temp.update');
        Route::post('/delete_image_order_temp_update', [TempOrderController::class, 'deleteImageOrders'])->name('delete.image.order.temp.update');
        Route::post('/delete_temp_update', [TempOrderController::class, 'deleteTempUpdate'])->name('delete.temp.update');
        Route::post('/delete_temp_create', [TempOrderController::class, 'deleteTempCreate'])->name('delete.temp.create');
        Route::get('/get_busy_housing_statuses/{id}', [InstitutionalProjectController::class, 'getBusyDatesByStatusType'])->name('get.busy.housing.statuses');
        Route::post('/change_step_order', [TempOrderController::class, 'changeStepOrder'])->name('change.step.order');
        Route::get('/get_housing_type_id/{slug}', [TempOrderController::class, 'getHousingTypeId'])->name('get.housing.type.id');
        Route::post('/temp_order_image_add', [TempOrderController::class, 'addTempImage'])->name('temp.order.image.add');
        Route::post('/temp_order_single_file_add', [TempOrderController::class, 'singleFile'])->name('temp.order.single.file.add');
        Route::post('/temp_order_document_add', [TempOrderController::class, 'documentFile'])->name('temp.order.document.add');
        Route::post('/temp_order_change_data', [TempOrderController::class, 'dataChange'])->name('temp.order.data.change');
        Route::post('/temp_order_project_housing_data_change', [TempOrderController::class, 'projectHousingDataChange'])->name('temp.order.project.housing.change');
        Route::post('/add_project_image', [TempOrderController::class, 'addProjectImage'])->name('temp.order.project.add.image');
        Route::post('/copy_checkbox', [TempOrderController::class, 'copyCheckbox'])->name('temp.order.copy.checkbox');
        Route::get('/get_house_data', [TempOrderController::class, 'getHouseData'])->name('temp.order.get.house.data');
        Route::post('/copy_item', [TempOrderController::class, 'copyData'])->name('temp.order.copy.data');
        Route::get('/housing_confirm_full', [TempOrderController::class, 'housingConfirmFull'])->name('temp.order.housing.confirm.full');
        Route::get('/get_doping_price', [TempOrderController::class, 'getDopingPrice'])->name('temp.order.get.doping.price');
        Route::post('/add_house_block', [TempOrderController::class, 'addBlockHousing'])->name('temp.order.add.house.block');
        Route::get('/get_block_data', [TempOrderController::class, 'getBlockData'])->name('temp.order.get.block.data');
        Route::get('/remove_block_data', [TempOrderController::class, 'removeBlock'])->name('temp.order.remove.block.data');
        Route::get('/location_control', [TempOrderController::class, 'locationControl'])->name('temp.order.location.control');
        
    });

    Route::middleware(['checkPermission:DeleteOffer'])->group(function () {
        Route::delete('/offers/{offer}', [InstitutionalOfferController::class, 'destroy'])->name('offers.delete');
    });

    Route::middleware(['checkPermission:GetOffers'])->group(function () {
        Route::get('/offers', [InstitutionalOfferController::class, 'index'])->name('offers.index');
    });

    // User Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateUser'])->group(function () {
        Route::get('/users/create', [InstitutionalUserController::class, 'create'])->name('users.create');
        Route::post('/users', [InstitutionalUserController::class, 'store'])->name('users.store');
    });

    Route::middleware(['checkPermission:GetUserById'])->group(function () {
        Route::get('/users/{user}/edit', [InstitutionalUserController::class, 'edit'])->name('users.edit');
    });

    Route::middleware(['checkPermission:UpdateUser'])->group(function () {
        Route::put('/users/{user}', [InstitutionalUserController::class, 'update'])->name('users.update');
    });

    Route::middleware(['checkPermission:GetUsers'])->group(function () {
        Route::get('/users', [InstitutionalUserController::class, 'index'])->name('users.index');
    });

    Route::middleware(['checkPermission:DeleteUser'])->group(function () {
        Route::delete('/users/{user}', [InstitutionalUserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware(['checkPermission:CreateRole'])->group(function () {
        Route::get('/roles/create', [InstitutionalRoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [InstitutionalRoleController::class, 'store'])->name('roles.store');
    });

    Route::middleware(['checkPermission:GetRoleById'])->group(function () {
        Route::get('/roles/{role}/edit', [InstitutionalRoleController::class, 'edit'])->name('roles.edit');
    });

    // Rol Düzenleme Sayfasına Erişim Kontrolü (UpdateRole izni gerekli)
    Route::middleware(['checkPermission:UpdateRole'])->group(function () {
        Route::put('/roles/{role}', [InstitutionalRoleController::class, 'update'])->name('roles.update');
    });

    // Rol Listeleme Sayfasına Erişim Kontrolü (GetRoles izni gerekli)
    Route::middleware(['checkPermission:GetRoles'])->group(function () {
        Route::get('/roles', [InstitutionalRoleController::class, 'index'])->name('roles.index');
    });

    // Rol Silme İşlemi için Erişim Kontrolü (DeleteRole izni gerekli)
    Route::middleware(['checkPermission:DeleteRole'])->group(function () {
        Route::delete('/roles/{role}', [InstitutionalRoleController::class, 'destroy'])->name('roles.destroy');
    });

    // Profile Controller Rotasının İzinleri
    Route::middleware(['checkPermission:EditProfile'])->group(function () {
        Route::get('/profile/edit', [InstitutionalProfileController::class, "edit"])->name('profile.edit');
        Route::put('/profile/update', [InstitutionalProfileController::class, "update"])->name('profile.update');
        Route::get('/profile/upgrade', [InstitutionalProfileController::class, 'upgrade'])->name('profile.upgrade');
        Route::post('/profile/upgrade/{id}', [InstitutionalProfileController::class, 'upgradeProfile'])->name('profile.upgrade.action');
    });

    Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');

    // ChangePassword Controller Rotasının İzinleri
    Route::middleware(['checkPermission:ChangePassword'])->group(function () {
        Route::get('/password/edit', [InstitutionalChangePasswordController::class, "edit"])->name('password.edit');
        Route::post('/password/update', [InstitutionalChangePasswordController::class, "update"])->name('password.update');
    });

    Route::get('/', [DashboardController::class, "index"])->name("index");

    Route::resource('/brands', BrandController::class);
    Route::resource('/projects', InstitutionalProjectController::class);
    Route::get('/projects/{project_id}/housings', [InstitutionalProjectController::class, 'housings'])->name('projects.housings');
    Route::get('/projects/{project_id}/housings/edit/{room_order}', [InstitutionalProjectController::class, 'editHousing'])->name('projects.edit.housing');
    Route::post('/projects/{project_id}/housings/edit/{room_order}', [InstitutionalProjectController::class, 'editHousingPost'])->name('projects.edit.housing.post');
    Route::get('/projects/{project_id}/housings/edit/{room_order}/delete', [InstitutionalProjectController::class, 'deleteHousingPost'])->name('projects.delete.housing');

    Route::post('/end_extend_time', [PaymentTempController::class, "createPaymentTemp"])->name('create.payment.end.temp');
    Route::post('/end_project_temp_order', [InstitutionalProjectController::class, "createProjectEnd"])->name('project.end.temp.order');
    Route::post('/update_project_temp_order', [InstitutionalProjectController::class, "updateProjectEnd"])->name('project.update.temp.order');
    Route::get('/create_project_v2', [InstitutionalProjectController::class, "createV2"])->name('project.create.v2');
    Route::get('/get_bank_account/{id}', [InstitutionalBankAccountController::class, "getBankAccount"])->name('get.bank.account');

    Route::post('/end_project_temp_order', [InstitutionalProjectController::class, "createProjectEnd"])->name('project.end.temp.order');
    Route::post('/update_project_temp_order', [InstitutionalProjectController::class, "updateProjectEnd"])->name('project.update.temp.order');
    Route::get('/edit_project_v2/{projectSlug}', [InstitutionalProjectController::class, "editV2"])->name('project.edit.v2');
    Route::get('/get_housing_type_childrens/{parentSlug}', [InstitutionalProjectController::class, "getHousingTypeChildren"])->name('get.housing.type.childrens');
    Route::get('/projects/{project_id}/logs', [InstitutionalProjectController::class, 'logs'])->name('projects.logs');
    Route::get('/housings/{housing_id}/logs', [InstitutionalHousingController::class, 'logs'])->name('housing.logs');
    Route::get('/project_stand_out/{project_id}', [InstitutionalProjectController::class, "standOut"])->name('project.stand.out');
    Route::get('/get_stand_out_total_price', [InstitutionalProjectController::class, "getStandOutPrices"])->name('project.stand.out.total.price');
    Route::post('/project_stand_out/{project_id}', [InstitutionalProjectController::class, "standOutPost"])->name('stand.out.post');
    Route::get('/get_stand_out_prices', [InstitutionalProjectController::class, "pricingList"])->name('project.pricing.list');
    Route::get('/get_counties', [InstitutionalProjectController::class, "getCounties"])->name('get.counties');
    Route::get('/single_prices', [SinglePriceController::class, "getSinglePrice"])->name('get.single.price');
    Route::get('/get_neighbourhood', [InstitutionalProjectController::class, "getNeighbourhood"])->name('get.neighbourhood');
    Route::post('/buy_order', [BuyController::class, "buyOrder"])->name('buy.order');
    Route::middleware(['checkPermission:NewProjectImage'])->group(function () {
        Route::post('/new_project_file/{project_id}', [InstitutionalProjectController::class, "newProjectImage"])->name('new.project.image');
        Route::post('/delete_project_image/{project_id}/{filename}', [InstitutionalProjectController::class, "deleteProjectImage"])->name('delete.project.image');
        Route::post('/remove_project_housing_file', [InstitutionalProjectController::class, "removeProjectHousingFile"])->name('remove.project.housing.image');
        Route::post('/add_project_housing_file', [InstitutionalProjectController::class, "addProjectHousingFile"])->name('add.project.housing.image');
    });

    Route::middleware(['checkPermission:NewHousingImage'])->group(function () {
        Route::post('/new_housing_file', [InstitutionalHousingController::class, "newHousingImage"])->name('new.housing.image');
        Route::post('/delete_housing_image', [InstitutionalHousingController::class, "deleteHousingImage"])->name('remove.housing.image');
    });

    Route::middleware(['checkPermission:CreateStoreBanner'])->group(function () {
        Route::get('/store-banners/create', [StoreBannerController::class, 'create'])->name('storeBanners.create');
        Route::post('/store-banners', [StoreBannerController::class, 'store'])->name('storeBanners.store');
    });

    Route::middleware(['checkPermission:GetStoreBannerById'])->group(function () {
        Route::get('/store-banners/{storeBanner}/edit', [StoreBannerController::class, 'edit'])->name('storeBanners.edit');
    });

    Route::middleware(['checkPermission:UpdateStoreBanner'])->group(function () {
        Route::put('/store-banners/{storeBanner}', [StoreBannerController::class, 'update'])->name('storeBanners.update');
    });

    Route::middleware(['checkPermission:GetStoreBanners'])->group(function () {
        Route::get('/store-banners', [StoreBannerController::class, 'index'])->name('storeBanners.index');
        Route::post('/store-banners/update-order', [StoreBannerController::class, 'updateOrder'])
            ->name('storeBanners.updateOrder');
    });

    Route::middleware(['checkPermission:DeleteStoreBanner'])->group(function () {
        Route::delete('/store-banners/{storeBanner}', [StoreBannerController::class, 'destroy'])->name('storeBanners.destroy');
    });

    Route::middleware(['checkPermission:CreateHousing'])->group(function () {
        Route::get('/create_housing', [InstitutionalHousingController::class, 'create'])->name('housing.create');
        Route::get('/create_housing_v2', [InstitutionalHousingController::class, 'createV2'])->name('housing.create.v2');
        Route::post('/create_housing', [InstitutionalHousingController::class, 'store'])->name('housing.store');
        Route::post('/create_housing_v2', [InstitutionalHousingController::class, 'finishByTemp'])->name('housing.store.v2');
    });
    Route::middleware(['checkPermission:UpdateHousing'])->group(function () {
        Route::get('/edit_housing/{id}', [InstitutionalHousingController::class, 'edit'])->name('housing.edit');
        Route::post('/edit_housing/{id}', [InstitutionalHousingController::class, 'update'])->name('housing.update');
        Route::get('/edit_images/{id}', [InstitutionalHousingController::class, 'editImages'])->name('housing.images.update');
        Route::post('/add_image/{id}', [InstitutionalHousingController::class, 'addProjectImage'])->name('housing.image.add');
        Route::post('/delete_image/{id}', [InstitutionalHousingController::class, 'deleteProjectImage'])->name('housing.image.delete');
        Route::post('/update_orders/{id}', [InstitutionalHousingController::class, 'updateOrders'])->name('housing.update.orders');
        Route::post('/change_cover_image/{id}', [InstitutionalHousingController::class, 'changeCoverImage'])->name('housing.change.cover.image');
        Route::get('/remove_housing/{id}', [InstitutionalHousingController::class, 'destroy'])->name('housing.remove.housing');
    });

    Route::middleware(['checkPermission:ListHousingInstitutional'])->group(function () {
        Route::get('/housings', [InstitutionalHousingController::class, 'index'])->name('housing.list');
    });
    Route::get('/my-reservations', [DashboardController::class, 'getMyReservations'])->name('myreservations');

    Route::middleware(['checkPermission:ShowCartOrders'])->group(function () {
        Route::get('/my-orders', [ClientPanelProfileController::class, "cartOrders"])->name('profile.cart-orders');
        Route::get('/invoice/{order}', [InstitutionalInvoiceController::class, "show"])->name('invoice.show');
        Route::post('/generate-pdf', [InvoiceController::class, "generatePDF"]);

    });

});

Route::post('/pay/cart', [CartController::class, 'payCart'])->name('pay.cart');
Route::get('/pay/success/{cart_order}', [CartController::class, 'paySuccess'])->name('pay.success');

Route::group(['prefix' => 'hesabim', "as" => "client.", 'middleware' => ['client', 'checkAccountStatus']], function () {
    Route::get('/reservations', [ClientPanelProfileController::class, 'getReservations'])->name('reservations');

    Route::get('/verify', [ClientPanelProfileController::class, 'verify'])->name('account-verification');
    Route::post('/verify', [ClientPanelProfileController::class, 'verifyAccount'])->name('verify-account');
    Route::get('/get-document', [ClientPanelProfileController::class, 'getIdentityDocument'])->name('get.identity-document');

    // Profile Controller Rotasının İzinleri
    Route::middleware(['checkPermission:EditProfile'])->group(function () {
        Route::get('/profili-guncelle', [ClientPanelProfileController::class, "edit"])->name('profile.edit');
        Route::put('/profile/update', [ClientPanelProfileController::class, "update"])->name('profile.update');
    });

    Route::middleware(['checkPermission:UpgradeProfile'])->group(function () {
        Route::get('/profili-yukselt', [ClientPanelProfileController::class, "upgrade"])->name('profile.upgrade');
        Route::post('/profili-yukselt/{id}', [ClientPanelProfileController::class, "upgradeProfile"])->name('profile.upgrade.action');
    });

    Route::get('/get_housing_type_childrens/{parentSlug}', [InstitutionalProjectController::class, "getHousingTypeChildren"])->name('get.housing.type.childrens');

    Route::post('/create_housing_v2', [InstitutionalHousingController::class, 'finishByTemp'])->name('housing.store.v2');
    Route::get('/get_busy_housing_statuses/{id}', [InstitutionalProjectController::class, 'getBusyDatesByStatusType'])->name('get.busy.housing.statuses');
    Route::post('/change_step_order', [TempOrderController::class, 'changeStepOrder'])->name('change.step.order');
    Route::get('/get_housing_type_id/{slug}', [TempOrderController::class, 'getHousingTypeId'])->name('get.housing.type.id');
    Route::post('/temp_order_image_add', [TempOrderController::class, 'addTempImage'])->name('temp.order.image.add');
    Route::post('/temp_order_single_file_add', [TempOrderController::class, 'singleFile'])->name('temp.order.single.file.add');
    Route::post('/temp_order_document_add', [TempOrderController::class, 'documentFile'])->name('temp.order.document.add');
    Route::post('/temp_order_change_data', [TempOrderController::class, 'dataChange'])->name('temp.order.data.change');
    Route::post('/temp_order_project_housing_data_change', [TempOrderController::class, 'projectHousingDataChange'])->name('temp.order.project.housing.change');
    Route::post('/add_project_image', [TempOrderController::class, 'addProjectImage'])->name('temp.order.project.add.image');
    Route::post('/end_project_temp_order', [InstitutionalProjectController::class, "createProjectEnd"])->name('project.end.temp.order');
    Route::get('/housing_types/getForm/', [HousingTypeController::class, 'getHousingTypeForm'])->name('ht.getform');
    Route::get('/get_counties', [InstitutionalProjectController::class, "getCounties"])->name('get.counties');

    Route::get('/get_neighbourhood', [InstitutionalProjectController::class, "getNeighbourhood"])->name('get.neighbourhood');

    Route::middleware(['checkPermission:ShowCartOrders'])->group(function () {
        Route::get('/siparisler', [ClientPanelProfileController::class, "cartOrders"])->name('profile.cart-orders');
        Route::get('/fatura/{order}', [InvoiceController::class, "show"])->name('invoice.show');
        Route::post('/generate-pdf', [InvoiceController::class, "generatePDF"]);

    });

    // ChangePassword Controller Rotasının İzinleri
    Route::middleware(['checkPermission:ChangePassword'])->group(function () {
        Route::get('/sifreyi-degistir', [ClientPanelChangePasswordController::class, "edit"])->name('password.edit');
        Route::post('/password/update', [ClientPanelChangePasswordController::class, "update"])->name('password.update');
    });

    // AdminHomeController Rotalarının İzinleri
    Route::middleware(['checkPermission:ViewDashboard'])->group(function () {
        Route::get('/', [ClientPanelDashboardController::class, "index"])->name("index");
        Route::get('/konut_olustur', [OrderController::class, "createHousing"])->name("create.housing");
        Route::post('/order', [OrderController::class, 'createOrder'])->name('create.order');
        Route::get('/getOrders', [OrderController::class, 'getOrders']);
    });

    // User Controller İzin Kontrolleri
    Route::middleware(['checkPermission:CreateUser'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

});

// Route::get('kategori/{slug}', [ClientProjectController::class, "allProjects"])
//     ->name('all.project.list');

Route::get('kategori/{slug?}/{type?}/{optional?}/{title?}/{check?}', [ClientProjectController::class, "allMenuProjects"])
    ->name('all.menu.project.list');

// Kullanıcı sayfası
Route::get('/user-chat', [SupportChatController::class, 'userChat']);
Route::post('/messages/store', [SupportChatController::class, 'store'])->name('messages.store');


// Admin sayfası
Route::get('/admin-chat', [SupportChatController::class, 'adminChat']);
Route::get('/chat/history', [SupportChatController::class, 'getChatHistory']);
