<?php
use App\Http\Controllers\SendSMSController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Http\Controllers\SmsApi;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function()
{
    //Admin Login Route
    Route::match(['get','post'],'login','AdminController@login');
    Route::group(['midleware'=>['admin']],function()
    {
        //Admin Dashboard Route
        Route::get('dashboard','AdminController@dashboard');

        //Admin logout
        Route::get('logout','AdminController@logout');
        //Update Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

        //Check Admin Password
        Route::post('check-admin-password','AdminController@checkAdminPassword');

        //Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        //Check Admin Details
        Route::post('check-admin-details','AdminController@checkAdminDetails');

        //Update Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');

        //View Admins / SubAdmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        //View Vendor Details
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');

        //Update Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');

        //Sections
        Route::get('sections','SectionController@sections');
        //Update section Status
        Route::post('update-section-status','SectionController@updateSectionStatus');
        //delete section
        Route::get('delete-section/{id}','SectionController@deleteSection');
        //add-edit section
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

         //Brands
         Route::get('brands','BrandController@brands');
         //Update Brands Status
         Route::post('update-brand-status','BrandController@updateBrandStatus');
         //delete Brands
         Route::get('delete-brand/{id}','BrandController@deleteBrand');
         //add-edit Brands
         Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');


        //Categories
        Route::get('categories','CategoryController@categories');
        //Update categories Status
         Route::post('update-category-status','CategoryController@updateCategoryStatus');
        //Update categories Add-edit
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        //append-categories-level
        Route::get('append-categories-level','CategoryController@appendCategoryLevel');
        //delete categories
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        //delete category image
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');


        //Products
        Route::get('products','ProductsController@products');
        //Update products Status
         Route::post('update-product-status','ProductsController@updateProductStatus');
        //delete products
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        //add-edit-product
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        //delete products image
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
         //delete products image
         Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');


         //Attributes
         Route::match(['get','post'],'add-edit-attributes/{id}','ProductsController@addAttributes');
          //Update attributes Status
          Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
          //delete attributes
          Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');
        //edit attributes        
          Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

          //Filters
          Route::get('filters','FilterController@filters');
          Route::get('filters-values','FilterController@filtersValues');
          //Update Filters Status
         Route::post('update-filter-status','FilterController@updateFilterStatus');
         Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');
         Route::match(['get','post'],'add-edit-filter/{id?}','FilterController@addEditFilter');
         Route::match(['get','post'],'add-edit-filter-value/{id?}','FilterController@addEditFilterValue');
         Route::post('category-filters','FilterController@categoryFilters');

          //Images
          Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
           //Update Image Status
           Route::post('update-image-status','ProductsController@updateImageStatus');
          //delete Image
          Route::get('delete-image/{id}','ProductsController@deleteImage');

          //Banners
          Route::get('banners','BannersController@banners');
          //Update Banners Status
          Route::post('update-banner-status','BannersController@updateBannerStatus');
          //delete Banners
          Route::get('delete-banner/{id}','BannersController@deleteBanner');
          //Update categories Add-edit
          Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');
          
          
          //Coupons
          Route::get('coupons','CouponsController@coupons');
          //Update Coupons Status
          Route::post('update-coupon-status','CouponsController@updateCouponStatus');
          //delete Coupons
          Route::get('delete-coupon/{id}','CouponsController@deleteCoupon');
          //add-edit-coupon
          Route::match(['get','post'],'add-edit-coupon/{id?}','CouponsController@addEditCoupon');

          //Users
          Route::get('users','UserController@users');
          //Update Users Status
          Route::post('update-user-status','UserController@updateUserStatus');
          
          

        
        

    });


});

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');
    
    //Listing Categories Routes
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    //dd($catUrls);die;
    foreach($catUrls as $key => $url){
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');
    }

//Vendor Products
Route::get('/products/{vendorid}','ProductsController@vendorListing');

//Product Detail Page
Route::get('/product/{id}','ProductsController@detail');

//Get Product Attribute  Price
Route::post('get-product-price','ProductsController@getProductPrice');

// Vendor Login/Register
Route::get('vendor/login-register','VendorController@loginRegister');

//Vendor Register
Route::post('vendor/register','VendorController@vendorRegister');

//Confirm Vendor Account
Route::get('vendor/confirm/{code}','VendorController@confirmVendor');

//Add to Cart
Route::post('cart/add','ProductsController@cartAdd');

//Cart Route
Route::get('cart','ProductsController@cart');

//Update Cart Item Quantity
Route::post('cart/update','ProductsController@cartUpdate');

//Delete Cart Item Quantity
Route::post('cart/delete','ProductsController@cartDelete');

// User Login/Register
Route::get('user/login-register',['as'=>'login','uses'=>'UserController@loginRegister']);

// User Register
Route::post('user/register','UserController@userRegister');

Route::group(['middleware'=>['auth']],function(){

    // User Account
    Route::match(['GET','POST'],'user/account','UserController@userAccount');

    //User Update Password
    Route::post('user/update-password','UserController@userUpdatePassword');

    //Apply Coupon
    Route::post('/apply-coupon','ProductsController@applyCoupon');

    //Checkout
    Route::match(['GET','POST'],'/checkout','ProductsController@checkout');

    //Get Delivery Address
    Route::post('get-delivery-address','AddressController@getDeliveryAddress');

    //Save Delivery Address
    Route::post('save-delivery-address','AddressController@saveDeliveryAddress');

});

//User Login
Route::post('user/login','UserController@userLogin');

//User Forgot Password
Route::match(['get','post'],'user/forgot-password','UserController@forgotPassword');

//User Logout
Route::get('user/logout','UserController@userLogout');

//Confirm User Account
Route::get('user/confirm/{code}','UserController@confirmAccount');




});

//Send SMS 
Route::get('/send_sms',[SendSMSController::class,'loadPage']);
Route::post('/send_sms',[SendSMSController::class,'sendSMS'])->name('sendSMS');


