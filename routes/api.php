<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\SubCategoryController;
use App\Http\Controllers\API\v1\SubscriptionPlanController;
use App\Http\Controllers\API\v1\CommonMasterController;
use App\Http\Controllers\API\v1\SubscriptionAddonController;
use App\Http\Controllers\API\v1\BlogController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\HomeController;
use App\Http\Controllers\API\v1\ContactUsController;
use App\Http\Controllers\API\v1\FavoriteController;
use App\Http\Controllers\API\v1\ChatController;
use App\Http\Controllers\Front\ProductController as WEBPROC;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/uploadAjaxImage', [WEBPROC::class, 'uploadAjaxImage']);

    Route::post('chatJobTrigger', [AuthController::class, 'chatJobTrigger']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('user/forgot/password', [AuthController::class, 'forgotPassword']);

// mapbox
        Route::get('/product/mapbox-list', [ProductController::class, 'getByCategory']);
    //--------for socket chat routes-------------//
    Route::post('user-on-off', [ChatController::class, 'userOnOff']);
    Route::post('room-create', [ChatController::class, 'roomCreate']);
    Route::post('thread-list', [ChatController::class, 'threadList']);
    Route::post('chat-detail', [ChatController::class, 'chatDetail']);
    Route::middleware(['throttle:500,1'])->group(function () {
        Route::post('send-message', [ChatController::class, 'sendMessage']);
    });
    Route::post('message-read', [ChatController::class, 'messageRead']);
    Route::post('message-delete', [ChatController::class, 'messageDelete']);
    Route::post('message-single-delete', [ChatController::class, 'singlemessageDelete']);
    Route::post('getUser', [ChatController::class, 'getUser']);
    Route::post('fileUpload', [ChatController::class, 'fileUpload']);

    Route::post('onbackthreadupdate', [ChatController::class, 'onbackthreadupdate']);
    Route::post('deletemychat', [ChatController::class, 'deletemychat']);
    Route::post('deleteMultipleUser', [ChatController::class, 'deleteMultipleUser']);
    //--------for socket chat routes-------------//


    Route::middleware(['ApiAuthenticate'])->group(function () {
        Route::get('/user/profile', [AuthController::class, 'userProfile']);
        Route::post('/user/profile/update', [AuthController::class, 'updateProfile']);
        Route::post('/change/password', [AuthController::class, 'changePasswordUpdate']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/settings/details', [AuthController::class, 'settingDetail']);
        Route::post('/settings/details/update', [AuthController::class, 'settingUpdate']);

        // category list
        Route::get('/category/list', [CategoryController::class, 'index']);

        // sub-category list
        Route::post('/subcategory/list', [SubCategoryController::class, 'index']);

        // subscription plan list
        Route::post('/subscription/plan/list', [SubscriptionPlanController::class, 'index']);

        // subscription addon list
        Route::get('/subscription/addon/list', [SubscriptionAddonController::class, 'index']);

        // common master list
        Route::post('/common-master/list', [CommonMasterController::class, 'index']);

        // blog list
        Route::post('/blog/list', [BlogController::class, 'index']);
        Route::get('/blog/detail/{identifier}', [BlogController::class, 'show']);

        // product
        Route::post('/product/store', [ProductController::class, 'store']);
        Route::post('/product/update', [ProductController::class, 'update']);
        Route::post('/product/show', [ProductController::class, 'show']);
        Route::post('/product/list', [ProductController::class, 'allProductList']);
        Route::post('/product/filter/list', [ProductController::class, 'filterProducts']);
        Route::post('/product/delete', [ProductController::class, 'delete']);

        // home
        Route::get('/home/list', [HomeController::class, 'index']);

        // favorite
        Route::post('favorites/list', [FavoriteController::class, 'index']);
        Route::post('favorites/add', [FavoriteController::class, 'store']);
        Route::post('favorites/delete', [FavoriteController::class, 'destroy']);

        // contact us
        Route::post('/enquiry', [ContactUsController::class, 'submit']);
    });
});
