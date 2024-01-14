<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['namespace' => 'User'],
    function () {
        Route::get('lang', 'LanguageController@switchLang')->name('lang');
        Route::get('/', 'HomeController@index')->name('home');
        Route::view('/one','frontend.landing-page');
        Route::get('/products/{product_id}', 'ProductController@show')->name('product');
        Route::get('/packages', 'PackageController@index')->name('packages.index');
        Route::get('/package/{id}', 'PackageController@show')->name('packages.show');
        // Route::get('/packages/{id}', 'PackageController@getPackages');
        Route::get('/categories/{id}', 'CategoryController@show')->name('category');
        Route::post('/categories/{id}', 'CategoryController@filter')->name('category.filter');
        Route::get('/daily-deals', 'DailyDealController@index')->name('daily-deals');
        Route::get('payment/show','PaymentController@show')->name('payment.show');
        Route::get('/payment-methods', 'PaymentMethodController@index');
        Route::get('/payment-methods/city/{city}/{shipping_method}', 'PaymentMethodController@getMethodsOfCity');
        Route::get('/payment-methods/address/{address}/{shipping_method}', 'PaymentMethodController@getMethodsOfAddress');
        Route::get('/shipping-methods', 'ShippingMethodController@index');
        Route::get('/shipping-methods/address/{address}', 'ShippingMethodController@getMethodsForAddress');
        Route::get('/shipping-methods/city/{city}', 'ShippingMethodController@getMethodsForCity');
        Route::post('/autocomplete', 'SearchController@autocomplete')->name('autocomplete');
        Route::get('/filters', 'FilterController@index')->name('filter');
        Route::post('/coupon', 'CouponController@codeChecker');
        Route::get('package-by-id/{id}', 'PackageController@getPackages');
        Route::post('products-by-id', 'ProductController@products');
        Route::post('/subscribe', 'MailListController@store')->name('subscribe');
        Route::get('checkout', 'OrderController@checkout')->name('checkout');
        Route::post('order/buy', 'OrderController@buy');
        Route::get('order/{id}/print', 'OrderController@showBill')->name('order.success');
        Route::get('order/{id}/pdf', 'OrderController@pdfDownload')->name('order.pdfDownload');
        Route::get('testimonials', 'TestimonialController@index')->name('testimonials.index');
        Route::post('mobile-confirmation', 'OrderController@confirmMobile')->name('mobile_confirmation');
        Route::get('wholesalers', 'WholesalersController@show')->name('wholesalers.show');
        Route::post('wholesalers_send', 'WholesalersController@send')->name('wholesalers.send');
        Route::get('bankTransfer/{order_id}/{token?}', 'BankTransferController@show')->name('bankTransfer.show');
        Route::post('bankTransfer_send', 'BankTransferController@store')->name('bankTransfer.store');
        Route::get('/orders/{id}/{token?}', 'OrderController@show')->name('order');
        // Route::get('/offers', 'PackageController@offers')->name('offers');
        Route::resource('pages', 'PageController');
        Route::get('fast-orders', 'FastOrderController@show')->name('fastOrders.show');
        Route::post('fast-orders-store', 'FastOrderController@store')->name('fastOrders.store');
        Route::post('aramex/rate', 'ShippingMethodController@getShippingPrice')->name('aramex.getShippingPrice');
        Route::post('/paytabs/status', 'OrderController@paytabsStatus')->name('paytabs.status');

        // Moyasar
        Route::get('/moyasar/payments_redirect', 'MoyasarController@payments_redirect')->name('moyasar.payments_redirect');
        Route::post('/moyasar/payments_save', 'MoyasarController@payments_save')->name('moyasar.payments_save');
        
        Route::group(['middleware' => ['auth']],
            function () {
                Route::post('rate', 'RatingController@store');
                Route::post('order/purchase', 'OrderController@purchase')->name('purchase');
                Route::get('latest-wishlist', 'WishlistController@latestWishlist')->name('latest-wishlist');
                Route::get('getWishlist', 'WishlistController@getWishlist')->name('getWishlist');
                Route::post('wishlist/{product_id}', 'WishlistController@toggleItemStatus');
                Route::post('whenAvailable/{product_id}', 'ProductController@whenAvailable');
                Route::get('profile', 'UserController@show')->name('profile');
                Route::resource('users', 'UserController');
                Route::get('/latest-orders', 'OrderController@latestOrders')->name('latest-orders');
                Route::resource('addresses', 'AddressController')->only(['store', 'index']);
                Route::get('addresses/destroy/{id}', 'AddressController@destroy')->name('addresses.destroy');

            });
    });

/*
 * Admin Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Admin'],
    function () {
        Route::get('/positionables/{position_name}', 'PositionController@getPositionables');
        Route::get('/positionables/banner/{id}', 'BannerController@getPositionableBanner');
        Route::get('/positionables/featured-products/{id}', 'FeaturedProductController@getPositionableFeaturedProducts');
        Route::get('/countries', 'CountryController@countriesWithCities');
        Route::get('/google-merchant/feed', 'GoogleMerchantController@feed');

        Route::group(['prefix' => 'admin',
                      'as'     => 'admin.',
                      'middleware' => ['AdminMiddleware']],
            function () {
                Route::get('/', 'AdminController@dashboard');
                Route::get('/dashboard', 'AdminController@dashboard');
                Route::post('product/show/updateAttr', 'ProductAttributeController@update');
                Route::post('product/show/destroy', 'ProductAttributeController@destroy');
                //Route::get('product/attibutes/{group_id}', 'ProductController@getGroupAttribute')->name('ajax_attributes');
                Route::get('product/show/myform/ajax/{id}', 'ProductController@myformAjax');
                Route::post('shipping-methods/{id}/cash-on-delivery', 'ShippingMethodController@cashOnDelivery');
                Route::put('product/{product}/description', 'ProductController@updateProductDescription');
                Route::post('product/{product}/filters', 'ProductController@updateProductFilters');
                Route::post('products/related/{product}', 'ProductController@updateRelatedProducts');
                Route::get('products/whenAvailable/{product_id}', 'ProductController@whenAvailable')->name('product.whenAvailable');

                Route::post('products/{id}/addImage', 'ProductController@addMediaFile')->name('products.addMediaFile');
                Route::post('products/{id}/addBackground', 'ProductController@addMediaBackground')->name('products.addMediaBackground');
                Route::post('options/{id}/addImage', 'ProductOptionController@addImage')->name('options.addImage');
                Route::post('positions/{id}/sort', 'PositionController@sort');
                Route::get('positionables', 'PositionController@positionsList');
                Route::post('/banners/{banner_id}/media/{media_id}', 'BannerController@updateMedia');
                Route::get('/banners/{banner_id}/media/{media_id}/delete', 'BannerController@deleteMedia');

                Route::resource('addresses', 'AddressController')->except(['store']);
                Route::resource('attributeGroups', 'AttributeGroupController');
                Route::resource('attributes', 'AttributeController');
                Route::resource('banners', 'BannerController');
                Route::resource('blocks', 'BlockController');
                Route::resource('pages', 'PageController');
                Route::resource('categories', 'CategoryController');
                Route::resource('districts', 'DistrictController');
                Route::resource('district-zones', 'DistrictZoneController');
                Route::resource('cities', 'CityController');
                Route::resource('countries', 'CountryController');
                Route::resource('coupons', 'CouponController');
                Route::resource('dailyDeals', 'DailyDealController');
                Route::resource('featured-products', 'FeaturedProductController');
                Route::resource('filter-options', 'FilterOptionController');
                Route::resource('filters', 'FilterController');
                Route::resource('mail-list', 'MailListController');
                Route::resource('manufacturers', 'ManufacturerController');
                Route::resource('media', 'MediaController');
                Route::get('bank-transfer-orders', 'OrderController@bankTransferOrders');
                Route::get('changeToPreparing/{order_id}', 'OrderController@changeToPreparing')->name('changeToPreparing');
                Route::get('changeToCanceled/{order_id}', 'OrderController@changeToCanceled')->name('changeToCanceled');
                Route::get('sendToAramex/{order_id}', 'OrderController@sendToAramex')->name('sendToAramex');
                Route::post('addOrderHistory', 'OrderController@addOrderHistory')->name('addOrderHistory');
                Route::get('aramexLabel/{id}', 'OrderController@aramexLabel')->name('order.aramexLabel');
                Route::get('aramexTrackShipment/{id}/{order_id}', 'OrderController@aramexTrackShipment')->name('order.aramexTrackShipment');
                Route::resource('orders', 'OrderController');
                Route::resource('packages', 'PackageController');
                Route::resource('payment-methods', 'PaymentMethodController');
                Route::resource('permissions', 'PermissionController');
                Route::resource('product-labels', 'ProductLabelController');
                Route::resource('productAttributes', 'ProductAttributeController');
                Route::resource('products', 'ProductController');
                Route::resource('products-properties', 'ProductPropertyController');
                Route::delete('products-properties/values/{id}', 'ProductPropertyController@delete_value');
                Route::resource('products/{product_id}/options', 'ProductOptionController');
                Route::resource('questions', 'QuestionController');
                Route::resource('ratings', 'RatingController');
                Route::resource('roles', 'RoleController');
                Route::resource('shipping-methods', 'ShippingMethodController');
                Route::resource('users', 'UserController', ['except' => 'show']);
                Route::get('mail-list-export', 'UserController@export')->name('users.export');
                Route::resource('testimonials', 'TestimonialController');
                Route::resource('fast-orders', 'FastOrderController');
                Route::get('settings', 'SettingsController@edit');
                Route::put('settings/update', 'SettingsController@update');
                Route::resource('positions', 'PositionController', ['only' => [
                    'index', 'edit'
                ]]);

                Route::group(['prefix' => 'reports',
                              'as'     => 'reports.',
                              'middleware' => ['AdminMiddleware']],
                function () {
                    Route::get('coupons', 'ReportsController@couponsIndex');
                    Route::get('coupons/{id}', 'ReportsController@couponsShow');
                });
            });
    });