<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\SubscriptionController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ChatController;
use App\Http\Controllers\Front\CommunityEventsController;
use App\Http\Controllers\Front\HjForumController;
use App\Http\Controllers\Front\ProductListingController;
use App\Http\Controllers\Front\SoldController;
use App\Http\Controllers\Front\TermPrivacyController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\ProductReviewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\MapBoxController;

use App\Http\Controllers\StripeSubscriptionController;

Route::get('/plan', [StripeController::class, 'plan'])->name('subscribe');
Route::post('/subscribe', [StripeController::class, 'subscribe'])->name('subscribe.process');

Route::get('/admins', function () {
    return redirect()->route('admin.login');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/universalSearch', [HomeController::class, 'universalSearch'])->name('universalSearch');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('loginPost');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('registerPost');
Route::get('verify-account/{token}/{resetType?}', [AuthController::class, 'verifyNewAccount'])->name('verify.account');

// newsletter
Route::post('newsletter-subscribe', [HomeController::class, 'newsletterSubscribe'])->name('newsletter.subscribe');


Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('password/reset/{token}/{resetType?}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile-edit', [AuthController::class, 'profileEdit'])->name('profile-edit');
    Route::post('/profileUpdate', [AuthController::class, 'profileUpdate'])->name('profileUpdate');
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePasswordUpdate']);
    Route::get('/settings', [AuthController::class, 'settings'])->name('settings');
    Route::post('/settingUpdate', [AuthController::class, 'settingUpdate'])->name('settingUpdate');
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription');
    Route::get('/purchase-plan/{encodeId}', [SubscriptionController::class, 'purchase_plan'])->name('purchase_plan');


    //Stipe Conenct Code
Route::get('/connect_stipe_account', [StripeController::class, 'connect_stipe_account'])->name('connect_stipe_account');
Route::get('/updateAccountDetails', [StripeController::class, 'updateAccountDetails'])->name('updateAccountDetails');


    
    //---------------below route is related to add products---------------------///
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/removeImage/{id}', [ProductController::class, 'removeImage'])->name('removeImage');
    Route::get('/removeVideo/{id}', [ProductController::class, 'removeVideo'])->name('removeVideo');
    Route::get('/removeDocument/{id}', [ProductController::class, 'removeDocument'])->name('removeDocument');
    Route::post('/product', [ProductController::class, 'storeProduct'])->name('product');
    Route::get('/editProduct/{id}', [ProductController::class, 'editProduct'])->name('editProduct');
    Route::get('/productList', [ProductController::class, 'productList'])->name('productList');
    Route::get('product/delete/{id}', [ProductController::class, 'productDelete'])->name('product/delete'); 
    Route::post('favorite/{product}', [ProductController::class, 'toggleFavorite'])->name('favorite'); 
    Route::post('/update-product-status', [ProductController::class, 'updateStatus'])->name('update.product.status');
    Route::get('/product/bid-detail/{id}', [ProductController::class, 'productBidDetail'])->name('product.bid-detail');
    Route::get('/product/checkout_new/{id}', [ProductController::class, 'checkout'])->name('product.checkout');
    Route::post('/product/checkout/{product_id}', [ProductController::class, 'paymentCheckout'])->name('product.checkout.process');
    Route::get('/checkout/success', [ProductController::class, 'success'])->name('product.success');
    Route::get('/checkout/cancel', [ProductController::class, 'cancel'])->name('product.cancel');

    //---------horse product---------//
    Route::get('/productHorseDetails', [ProductController::class, 'productHorseDetails'])->name('productHorseDetails');
    Route::post('/productHorseDetails', [ProductController::class, 'storeProductHorseDetails'])->name('productHorseDetails');
    
    //---------Equipment & Apparel product---------//
    Route::get('/productEquipmentDetails', [ProductController::class, 'productEquipmentDetails'])->name('productEquipmentDetails');
    Route::post('/productEquipmentDetails', [ProductController::class, 'storeProductEquipmentDetails'])->name('productEquipmentDetails');
    
    //---------Barns & Housing product---------//
    Route::get('/productBarnsDetails', [ProductController::class, 'productBarnsDetails'])->name('productBarnsDetails');
    Route::post('/productBarnsDetails', [ProductController::class, 'storeProductBarnsDetails'])->name('productBarnsDetails');
    
    //---------Service & Jobs product---------//
    Route::get('/productServiceDetails', [ProductController::class, 'productServiceDetails'])->name('productServiceDetails');
    Route::post('/productServiceDetails', [ProductController::class, 'storeProductServiceDetails'])->name('productServiceDetails');

    
    //----hj forms routes-----//
    Route::resource('hjForum', HjForumController::class);
    Route::get('hjForum/delete/{id}', [HjForumController::class, 'destroy'])->name('hjForum.delete'); 
    
    //------Community & Events routes----------//
    Route::resource('community', CommunityEventsController::class);
    Route::get('community/delete/{id}', [CommunityEventsController::class, 'destroy'])->name('community.delete');
    
    //------------Chat Messanger-------------//
    Route::get('/messages', [HomeController::class, 'chatMessage'])->name('messages');
    
});


//-----contact Ad Owner route-----//
Route::post('/contactAdOwner', [HomeController::class, 'contactAdOwner'])->name('contactAdOwner');

//------Community & Events Joining route----------//
Route::get('/event/join/{id}', [CommunityEventsController::class, 'joinEvent'])->name('community.join');
Route::get('/event/success', [CommunityEventsController::class, 'success'])->name('event.success');
Route::get('/event/cancel', [CommunityEventsController::class, 'cancel'])->name('event.cancel');



//-------------below routes is realted to show horse products & filter--------------//

//-----------Horse product listing 0001-----------// 
Route::get('/horse-listing', [ProductListingController::class, 'horseListing'])->name('horse-listing');
Route::any('horse-listing/dataTable', [ProductListingController::class, 'getHorseDataTable'])->name('getHorseDataTable');
Route::get('/horseDetails/{id}', [ProductListingController::class, 'horseDetails'])->name('horseDetails');
Route::any('product/bids/store', [ProductController::class, 'bidStore'])->name('bid.store'); 
// product owner review
Route::post('/rate-product', [ProductReviewController::class, 'rate'])->name('product.rate');

// get category wise product
Route::get('/category-product-list', [ProductListingController::class, 'categoryWiseProduct'])->name('category.product.list');

//-----------Equipment & Apparel product listing 0002-----------//
Route::get('/equipment-listing', [ProductListingController::class, 'equipmentListing'])->name('equipment-listing');
Route::any('equipment-listing/dataTable', [ProductListingController::class, 'getEquipmentDataTable'])->name('getEquipmentDataTable');
Route::get('/equipmentDetails/{id}', [ProductListingController::class, 'equipmentDetails'])->name('equipmentDetails');


//-----------Barns & Housing product listing  0003-----------//
Route::get('/barns-listing', [ProductListingController::class, 'barnsListing'])->name('barns-listing');
Route::any('barns-listing/dataTable', [ProductListingController::class, 'getBarnsDataTable'])->name('getBarnsDataTable');
Route::get('/barnsDetails/{id}', [ProductListingController::class, 'barnsDetails'])->name('barnsDetails');


//-----------Service & & Housing product listing 0004-----------//
Route::get('/service-listing', [ProductListingController::class, 'serviceListing'])->name('service-listing');
Route::any('service-listing/dataTable', [ProductListingController::class, 'getServiceDataTable'])->name('getServiceDataTable');
Route::get('/serviceDetails/{id}', [ProductListingController::class, 'serviceDetails'])->name('serviceDetails');

//-------product commenting routes--------
Route::get('/productCommentListing/{id}', [HomeController::class, 'productCommentListing'])->name('productCommentListing');
Route::post('/productComment', [HomeController::class, 'productComment'])->name('productComment');
Route::post('/comment/update', [HomeController::class, 'commentUpdate'])->name('productComment.update');
Route::get('/productCommentDelete/{id}', [HomeController::class, 'productCommentDelete'])->name('comment.delete');





//------community events & details routes -----//
// Route::get('/community-events', [HomeController::class, 'communityEvents'])->name('community-events');

Route::get('/community-events', [CommunityEventsController::class, 'communityListing'])->name('community-events');
Route::any('community-listing/dataTable', [CommunityEventsController::class, 'getCommunityDataTable'])->name('getCommunityDataTable');
Route::get('/communityDetails/{id}', [CommunityEventsController::class, 'communityDetails'])->name('communityDetails');

//------compare 2 or more product -------//
Route::any('compare', [HomeController::class, 'compare'])->name('compare');



//-----related to blog-----//
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog-details/{id}', [BlogController::class, 'blogDetails'])->name('blog-details');

//------HJ forum ---------//
Route::get('/hj-forum', [HjForumController::class, 'hjForumListing'])->name('hj-forum');
Route::get('/hj-forum-details/{id}', [HjForumController::class, 'hjForumDetails'])->name('hj-forum-details');
Route::get('/forumCommentListing/{id}', [HjForumController::class, 'forumCommentListing'])->name('forumCommentListing');
Route::post('/forumComment', [HjForumController::class, 'forumComment'])->name('forumComment');
Route::post('forum/comment/update', [HjForumController::class, 'commentUpdate'])->name('forumComment.update');
Route::get('/forumCommentDelete/{id}', [HjForumController::class, 'forumCommentDelete'])->name('forum.comment.delete');


//---------------------------Need to work on below routes-------------------------------------------//


Route::get('/aboutus', [HomeController::class, 'aboutus'])->name('aboutus');
Route::get('/partnerships', [HomeController::class, 'partnerships'])->name('partnerships');

//------for checkout ----------//
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

//----- BID now page------//
Route::get('/bidNow', [HomeController::class, 'bidNow'])->name('bidNow');
Route::get('/occasion', [HomeController::class, 'occasion'])->name('occasion');
Route::get('/sale', [HomeController::class, 'sale'])->name('sale');


//------- no add found------//
Route::get('/notFound', [HomeController::class, 'notFound'])->name('notFound');
Route::get('/sold', [SoldController::class, 'sold'])->name('sold');
Route::any('/sold/data-list', [SoldController::class, 'soldDataTable'])->name('product.sold.datatable');

// cms web page
Route::get('/terms-conditions', [TermPrivacyController::class, 'terms'])->name('cms.terms.condition');
Route::get('/privacy-policies', [TermPrivacyController::class, 'policy'])->name('cms.privacy.policy');

// contact us web page
Route::get('/contact', [ContactUsController::class, 'show'])->name('contact.form');
Route::post('/contact', [ContactUsController::class, 'submit'])->name('contact.submit');

//-------------------------------------------------------------------------//
Route::post('/submitReport', [HomeController::class, 'submitReport'])->name('submitReport');
Route::get('/favorite', [HomeController::class, 'favorite'])->name('favorite');
Route::get('/review', [HomeController::class, 'review'])->name('review');
Route::get('/invoice', [HomeController::class, 'invoice'])->name('invoice');
// Route::get('/bidDetails', [HomeController::class, 'bidDetails'])->name('bidDetails');



Route::middleware(['auth:admin'])->group(function () {
    // Route::get('/sold', [HomeController::class, 'sold'])->name('sold');
});


Route::get('/webhook_stripe_for_connect', [StripeController::class, 'webhook_stripe_for_connect'])->name('webhook_stripe_for_connect');


