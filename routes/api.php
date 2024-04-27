<?php

use App\Http\Controllers\Api\Client\AddressController;
use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\BrandController;
use App\Http\Controllers\Api\Client\FavoriteController;
use App\Http\Controllers\Api\Client\FormController;
use App\Http\Controllers\Api\Client\HousingController;
use App\Http\Controllers\Api\Client\MenuController;
use App\Http\Controllers\Api\Institutional\ProjectController as InstitutionalProjectController;


use App\Http\Controllers\Api\Client\ProjectController;
use App\Http\Controllers\Api\Client\RealEstateController;
use App\Http\Controllers\Api\Client\SliderController as ClientSliderController;
use App\Http\Controllers\Api\Client\StoreController;
use App\Http\Controllers\Api\Client\TempOrderController;
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
Route::apiResource('housing', HousingController::class);
Route::apiResource('brand', BrandController::class);
Route::get('get_full_projects',[ProjectController::class,"getFullProjects"]);
Route::post('login',[AuthController::class,"login"]);
Route::post('register',[AuthController::class,"register"]);
Route::get('get_my_projects',[ProjectController::class,"getMyProjects"]);
Route::get('get_my_housings',[HousingController::class,"getMyHousings"]);
Route::get('get_my_project/{id}',[ProjectController::class,"getMyProject"]);
Route::delete('delete_project_gallery_image/{id}',[ProjectController::class,"deleteProjectGalleryImage"]);
Route::get('cities',[AddressController::class,"cities"]);
Route::get('counties/{cityId}',[AddressController::class,"getCountiesByCityId"]);
Route::get('neighborhoods/{county_id}',[AddressController::class,"getNeighborhoodsByCountyId"]);
Route::post('update_project',[ProjectController::class,"updateProject"]);
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

Route::apiResource('favorites', FavoriteController::class);
Route::post('add_housing_to_favorites/{housingId}', [FavoriteController::class, 'addHousingToFavorites']);