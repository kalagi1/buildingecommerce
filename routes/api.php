<?php

use App\Http\Controllers\Api\CartController as ApiCartController;
use App\Http\Controllers\Api\Client\AddressController;
use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\BrandController;
use App\Http\Controllers\Api\Client\FavoriteController;
use App\Http\Controllers\Api\Client\FormController;
use App\Http\Controllers\Api\Client\HousingController;
use App\Http\Controllers\Api\Client\MenuController;
use App\Http\Controllers\Api\Institutional\ProjectController as InstitutionalProjectController;
use App\Http\Controllers\Api\Client\TaxOfficeController;

use App\Http\Controllers\Api\Client\ProjectController;
use App\Http\Controllers\Api\Client\RealEstateController;
use App\Http\Controllers\Api\Client\SliderController as ClientSliderController;
use App\Http\Controllers\Api\Client\StoreController;
use App\Http\Controllers\Api\Client\TempOrderController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayController;

use App\Http\Controllers\Api\Client\PageController as ClientPageController;
use App\Http\Controllers\Api\Client\PayController as ClientPayController;
use App\Http\Controllers\Api\Institutional\BoughtController;
use App\Http\Controllers\Api\Institutional\CartController;
use App\Http\Controllers\Api\Institutional\RoleController as InstitutionalRoleController;

use App\Http\Controllers\Api\Institutional\FormController as InstitutionalFormController;
use App\Http\Controllers\Api\Institutional\ReturnController;
use App\Http\Controllers\Api\Institutional\SharerController;
use App\Http\Controllers\Api\Institutional\UserController;
use App\Http\Controllers\Api\InstitutionalClubController;
use App\Http\Controllers\Institutional\ProjectController as ControllersInstitutionalProjectController;
use App\Http\Controllers\Institutional\UserController as InstitutionalUserController;
use App\Http\Controllers\Api\Institutional\InfoController;
use App\Http\Controllers\Api\Institutional\HousingController as InstitutionalHousingController;
use App\Http\Controllers\Api\Client\NeighborViewController;
use App\Http\Controllers\Api\SupportController as ApiSupportController;
use App\Http\Controllers\MarkerController;

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

Route::get('/markers', [MarkerController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/featured-projects', [ProjectController::class, 'getFeaturedProjects']);
Route::get('/my_projects', [InstitutionalProjectController::class, "index"]);
Route::get('/popular-construction-brands', [StoreController::class, 'getFeaturedStores']);
Route::get('/popular-estate-brands', [StoreController::class, 'getFeaturedEstateStores']);

Route::get('/featured-sliders', [ClientSliderController::class, 'getFeaturedSliders']);
Route::get('dashboard-statuses', [HousingController::class, 'getDashboardStatuses']);
Route::get('/real-estates', [RealEstateController::class, 'getRealEstates']);
Route::get('/menu-list', [MenuController::class, 'getMenuList']);
Route::get('/project_housings/{projectId}', [ProjectController::class, 'getRooms']);
Route::apiResource('project', ProjectController::class);
Route::apiResource('housing', HousingController::class);
Route::apiResource('brand', BrandController::class);
Route::apiResource('return', ReturnController::class);
Route::get('get_full_projects', [ProjectController::class, "getFullProjects"]);
Route::post('login', [AuthController::class, "login"]);
Route::post('register', [AuthController::class, "register"]);
Route::get('get_my_projects', [ProjectController::class, "getMyProjects"]);
Route::get('get_my_housings', [HousingController::class, "getMyHousings"]);
Route::get('get_my_project/{id}', [ProjectController::class, "getMyProject"]);
Route::delete('delete_project_gallery_image/{id}', [ProjectController::class, "deleteProjectGalleryImage"]);
Route::get('cities', [AddressController::class, "cities"]);
Route::get('counties/{cityId}', [AddressController::class, "getCountiesByCityId"]);
Route::get('neighborhoods/{county_id}', [AddressController::class, "getNeighborhoodsByCountyId"]);
Route::post('update_project', [ProjectController::class, "updateProject"]);
Route::apiResource('swap', FormController::class);

Route::get('/get_temp_order_project/{id}', [TempOrderController::class, 'getTempOrderData']);

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
Route::post('/change_area_list_data', [TempOrderController::class, 'changeAreaListData'])->name('temp.order.change.area.list.data');
Route::post('/remove_pay_dec_item', [TempOrderController::class, 'removePayDecItem'])->name('temp.order.remove.pay.dec');
Route::post('/situation_image_add', [TempOrderController::class, 'situationImageAdd'])->name('temp.order.situation.add');
Route::post('/update_situation_order_temp_update', [TempOrderController::class, 'updateSituationOrders'])->name('update.situation.order.temp.update');
Route::post('/delete_situation_order_temp_update', [TempOrderController::class, 'deleteSituationOrders'])->name('delete.situation.order.temp.update');
Route::post('/pay', [ClientPayController::class, 'pay']);

Route::apiResource('favorites', FavoriteController::class);
Route::post('add_housing_to_favorites/{housingId}', [FavoriteController::class, 'addHousingToFavorites']);
Route::post('add_project_to_favorites/{housingId}', [FavoriteController::class, 'addProjectHousingToFavorites']);


Route::get('/get-tax-offices', [TaxOfficeController::class, "getTaxOffices"])->name("getTaxOffices");
Route::get('/get-tax-office/{taxOffice}', [TaxOfficeController::class, "getTaxOffice"])->name("getTaxOffice");

Route::get('sayfa/{slug}', [ClientPageController::class, 'index'])->name('page.show');
//sözleşmeler
Route::get('sozlesmeler', [ClientPageController::class, "contracts_show"])->name('contracts.show');
Route::get('/get-content/{target}', [ClientPageController::class, "getContent"])->name('get-content');

Route::post('password/email', [AuthController::class, "sendResetLinkEmail"])->name('password.email');

Route::get('kategori/{slug?}/{type?}/{optional?}/{title?}/{check?}/{city?}/{county?}/{hood?}', [ClientPageController::class, "allMenuProjects"])
    ->name('all.menu.project.list');

Route::get('/emlak-kulup/{userid}/koleksiyonlar/{id}', [SharerController::class, "showClientLinks"])->name('api.sharer.links.showClientLinks');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('housing_type_parents',[TempOrderController::class,"getHousingTypeParents"]);
    Route::get('housing_type_parent_by_parent_id/{parent_id}',[TempOrderController::class,"getHousingTypeParentByParentId"]);
    Route::get('support', [ApiSupportController::class, 'index']);
    Route::post('support', [ApiSupportController::class, 'sendSupportMessage']);
        
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/neighbor-view', [NeighborViewController::class, 'index']);
    Route::group(['prefix' => 'institutional', "as" => "institutional.", 'middleware' => ['institutional', 'checkCorporateAccount', "checkHasClubAccount"]], function () {
        Route::get('/collections/{id}', [SharerController::class, "show"])->name('collection.show');
        Route::get('my-cart', [CartController::class, 'index'])->name('cart');

        Route::Delete('/notifications', [InfoController::class, 'destroyAll']);
        Route::delete('/notification/delete', [InfoController::class, "notificationDestroyById"])->name('notificationDestroyById');
        Route::Delete('/housing-favorite', [InstitutionalHousingController::class, 'destroyAllFavorite']);
        Route::Delete('/project-favorite', [InstitutionalProjectController::class, 'destroyAllFavorite']);

        Route::delete('/favorites/delete', [FavoriteController::class, 'deleteFavorites']);
        Route::delete('/sub-users', [UserController::class, 'deleteSubUsers']);
        Route::delete('/rol-users', [InstitutionalRoleController::class, 'userType']);

        Route::middleware(['checkPermission:CreateRole'])->group(function () {
            Route::get('/roles/create', [InstitutionalRoleController::class, 'create'])->name('roles.create');
            Route::post('/roles', [InstitutionalRoleController::class, 'store'])->name('roles.store');
        });

        Route::middleware(['checkPermission:CreateUser'])->group(function () {
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
        });


        Route::middleware(['checkPermission:GetRoleById'])->group(function () {
            Route::get('/roles/{role}/edit', [InstitutionalRoleController::class, 'edit'])->name('roles.edit');
        });
        Route::middleware(['checkPermission:GetUserById'])->group(function () {
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        });
        Route::middleware(['checkPermission:GetUsers'])->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
        });

        // Rol Düzenleme Sayfasına Erişim Kontrolü (UpdateRole izni gerekli)
        Route::middleware(['checkPermission:UpdateRole'])->group(function () {
            Route::put('/roles/{role}', [InstitutionalRoleController::class, 'update'])->name('roles.update');
        });

        Route::middleware(['checkPermission:UpdateUser'])->group(function () {
            Route::put('/users/{user}', [InstitutionalUserController::class, 'update'])->name('users.update');
        });

        Route::put('/club/update', [InstitutionalClubController::class, 'clubUpdate'])->name('club.update');


        // Rol Listeleme Sayfasına Erişim Kontrolü (GetRoles izni gerekli)
        Route::middleware(['checkPermission:GetRoles'])->group(function () {
            Route::get('/roles', [InstitutionalRoleController::class, 'index'])->name('roles.index');
        });

        // Rol Silme İşlemi için Erişim Kontrolü (DeleteRole izni gerekli)
        Route::middleware(['checkPermission:DeleteRole'])->group(function () {
            Route::delete('/roles/{role}', [InstitutionalRoleController::class, 'destroy'])->name('roles.destroy');
        });

        Route::middleware(['checkPermission:DeleteUser'])->group(function () {
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        Route::get('/get_boughts', [BoughtController::class, 'bougths'])->name('react.bougths');
        Route::get('/get_solds', [BoughtController::class, 'solds'])->name('react.solds');
        Route::post('give_offer', [ProjectController::class, 'give_offer'])->name('give_offer');
        Route::get ('/user/offers', [ProjectController::class, 'giveOfferByUser']);
        Route::get('/order_detail/{order_id}', [ClientPageController::class, 'orderDetail'])->name('order.detail');
        Route::get('/invoice/{order}', [ClientPageController::class, "invoiceDetail"])->name('invoice.show');
        Route::post('add_to_cart/', [CartController::class, 'add'])->name('add.to.cart');
        Route::get('/kiraladiklarim', [CartController::class, 'getMyReservations'])->name('myreservations');

        Route::get('/swap_applications', [InstitutionalFormController::class, 'swapApplications'])->name('react.swap.applications');
        Route::get('/swap_applications/{form}', [InstitutionalFormController::class, 'showSwapApplication'])->name('react.show.swap.applications');
    }); 
    Route::post('/update-cart-qt', [ApiCartController::class, 'updateqt'])->name('cart.update.qt');
    Route::post('/update-cart', [ApiCartController::class, 'update'])->name('cart.update');
    Route::post('/remove-from-cart', [ApiCartController::class, 'removeFromCart'])->name('client.remove.from.cart');

    Route::get('/user/notification', [AuthController::class, "getUserNotifications"])->name('getUserNotifications');
    Route::get('/notifications', [AuthController::class, 'getAllNotifications']);
    
    //telefon doğrulama
    Route::post('/phone-verification/generate', [AuthController::class, 'generateVerificationCode'])
        ->name('phone.generateVerificationCode');

    Route::post('/phone-verification/verify', [AuthController::class, 'verifyPhoneNumber'])
        ->name('phone.verifyPhoneNumber');

    Route::post('/client/password/update', [AuthController::class, "clientPasswordUpdate"])->name('client.password.update');

    Route::put('/client/profile/update', [AuthController::class, "clientProfileUpdate"])->name('client.profile.update');

    Route::get('/client/collections', [ClientPageController::class, "clientCollections"])->name('client.collections');
    Route::put('/collection/{id}/edit', [ClientPageController::class, 'editCollection'])->name('collection.edit');
    Route::delete('/collection/{id}/delete', [ClientPageController::class, 'deleteCollection'])->name('collection.delete');
    Route::delete('/collections', [ClientPageController::class, 'deleteCollections']);

    Route::post('/remove-from-collection', [ClientPageController::class, 'removeFromCollection'])->name('remove.from.collection');

    Route::post('/add/collection', [ClientPageController::class, 'store']);

    Route::get('/getCollections', [ClientPageController::class, 'getCollections']);

    Route::post('/addLink', [ClientPageController::class, 'addLink'])->name('add.to.link');
    Route::post('/remove_item_on_collection', [ClientPageController::class, 'removeItemOnCollection'])->name('remove.item.on.collection');

    Route::post('/housing/{id}/send-comment', [HousingController::class, "sendComment"])->name('housing.send-comment');
});

Route::post('/preview', [InstitutionalProjectController::class, "getPreview"]);

Route::get('/project/{projectId}/comments',[InstitutionalProjectController::class,'getCommentsByProject']);
Route::post('/project/{projectId}/add-comment', [InstitutionalProjectController::class,'projectCommentPost']);

Route::post('/delete/comment',[ProjectController::class,'deleteComment']);