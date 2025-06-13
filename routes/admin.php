<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CMSPageController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\SubscriptionPlanAddonController;
use App\Http\Controllers\Admin\CommonMasterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\website\IndustryMetricController;
use App\Http\Controllers\Admin\website\HomeAboutController;
use App\Http\Controllers\Admin\website\SellerBusinessController;
use App\Http\Controllers\Admin\website\BuyerBrowserController;
use App\Http\Controllers\Admin\website\BuyerFaqController;
use App\Http\Controllers\Admin\website\AboutController;
use App\Http\Controllers\Admin\website\AboutSellerBusinessController;
use App\Http\Controllers\Admin\website\PartnershipContentController;
use App\Http\Controllers\Admin\website\PartnerShipCollaborateController;
use App\Http\Controllers\Admin\website\PartnershipWaysController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\SocialController;

// Route::middleware(['PreventBackHistory'])->group( function() {


// Admin login routes
Route::get('/login', [DashboardController::class, 'loginView'])->name('admin.login');
Route::post('/login/store', [DashboardController::class, 'login'])->name('admin.login.store');
// Redirect /admin to /admin/login
Route::get('/', function () {
    return redirect()->route('admin.login');
});
// Protected admin routes
Route::middleware(['auth:sanctum', 'checkAdminRole', 'PreventBackHistory', 'role:admin'])->group(function () {
    Route::post('/logout', [DashboardController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('change-password', [AdminPasswordController::class, 'edit'])->name('admin.change-password');
    Route::post('change-password', [AdminPasswordController::class, 'update'])->name('admin.change-password.update');

    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('blogs', BlogController::class);

    Route::resource('cms_pages', CMSPageController::class);
    Route::delete('cms_pages/{id}/image', [CMSPageController::class, 'deleteImage'])->name('cms_pages.image.delete');

    Route::resource('subscription_plans', SubscriptionPlanController::class);
    Route::post('subscription_plans/{id}/restore', [SubscriptionPlanController::class, 'restore'])->name('subscription_plans.restore');

    Route::resource('subscription-addons', SubscriptionPlanAddonController::class);
    Route::post('subscription-addons/{id}/restore', [SubscriptionPlanAddonController::class, 'restore'])->name('subscription-addons.restore');

    Route::resource('common-masters', CommonMasterController::class);
    Route::post('common-masters/{id}/restore', [CommonMasterController::class, 'restore'])->name('common-masters.restore');
    Route::post('common-masters/{commonMaster}/toggle-status', [CommonMasterController::class, 'toggleStatus'])->name('common-masters.toggleStatus');
    Route::get('common-masters/types/{categoryId}', [CommonMasterController::class, 'getTypesByCategory'])
    ->name('common-masters.types-by-category');

    // product
    Route::resource('/products', ProductController::class);
    Route::post('products/{product}/toggle-status/{category_id?}', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
    Route::get('products/count-feature/{categoryId}', [ProductController::class, 'countFeature'])->name('products.featured-count');
    Route::get('products/subcategory/{categoryId}', [ProductController::class, 'getSubcategoryByCategory'])
    ->name('products.subcategory-by-category');

    //enquiry
    Route::resource('enquiries', ContactUsController::class);

    // website manage
    Route::resource('industry_metrics', IndustryMetricController::class);
    // Route::delete('industry_metrics/delete/{id}', [IndustryMetricController::class, 'destroy'])->name('industry_metrics.delete');
    // Route::delete('industry_metrics/icon/delete/{id}', [IndustryMetricController::class, 'deleteIcon'])->name('industry_metrics.icon.delete');

    // home about
    Route::resource('home_about', HomeAboutController::class)->except(['show']);
    // Route::get('home-about/edit', [HomeAboutController::class, 'edit'])->name('home_about.edit');
    // Route::post('home-about/update', [HomeAboutController::class, 'update'])->name('home_about.edit');
    Route::get('home_about/show', [HomeAboutController::class, 'show'])->name('home_about.show');
    
    // partnership-content
    Route::resource('paertner_content', PartnershipContentController::class)->except(['show']);
    // Route::get('home-about/edit', [HomeAboutController::class, 'edit'])->name('home_about.edit');
    // Route::post('home-about/update', [HomeAboutController::class, 'update'])->name('home_about.edit');
    Route::get('partner_content/show', [PartnershipContentController::class, 'show'])->name('partner_content.show');
    Route::resource('partner_collaborate', PartnerShipCollaborateController::class)->except('show');
    Route::resource('partner_ways', PartnershipWaysController::class);
    
    // seller & business
    Route::resource('seller-business', SellerBusinessController::class)->except(['show']);
    // Route::get('home-about/edit', [HomeAboutController::class, 'edit'])->name('home_about.edit');
    // Route::post('home-about/update', [HomeAboutController::class, 'update'])->name('home_about.edit');
    Route::get('seller-business/show', [SellerBusinessController::class, 'show'])->name('seller-business.show');

    // buyer 
    Route::resource('buyers', BuyerBrowserController::class)->except('show');
    Route::get('buyers/show', [BuyerBrowserController::class, 'show'])->name('buyers.show');

    // buyer faq
    Route::resource('buyer-faqs', BuyerFaqController::class);
    // newsletter
    Route::resource('newsletters', NewsLetterController::class);
     // home about
    Route::resource('about', AboutController::class)->except(['show']);
    Route::get('about/show', [AboutController::class, 'show'])->name('about.show');
    
    // seller & business
    Route::resource('about-seller-business', AboutSellerBusinessController::class)->except(['show']);
    Route::get('about-seller-business/show', [AboutSellerBusinessController::class, 'show'])->name('about-seller-business.show');

    // website social links
    Route::get('/social-links/edit', [SocialController::class, 'edit'])->name('social.link');
    Route::put('/social-links/update', [SocialController::class, 'update'])->name('update.social.link');

});
