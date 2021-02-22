<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




//Driver Routes


Route::prefix('driver')->group(function () {
    Route::post('login', 'API\Driver\UserAPIController@login');
    Route::post('register', 'API\Driver\UserAPIController@register');
    Route::get('user', 'API\Driver\UserAPIController@user');
    Route::get('logout', 'API\Driver\UserAPIController@logout');
    Route::get('settings', 'API\Driver\UserAPIController@settings');
    Route::post('phone_verify', 'API\Driver\UserAPIController@phoneVerify');

});



//Manager Routes

Route::prefix('manager')->group(function () {
    Route::post('login', 'API\Manager\UserAPIController@login');
    Route::post('register', 'API\Manager\UserAPIController@register');
    Route::get('user', 'API\Manager\UserAPIController@user');
    Route::get('logout', 'API\Manager\UserAPIController@logout');

});

Route::post('paymentz', 'API\UserAPIController@paymentM');
Route::post('sendInvoice/{id}', 'API\OrderAPIController@generateInvoice');
Route::post('login', 'API\UserAPIController@login');
Route::post('register', 'API\UserAPIController@register');
Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
Route::get('user', 'API\UserAPIController@user');
Route::get('logout', 'API\UserAPIController@logout');
Route::get('settings', 'API\UserAPIController@settings');
Route::post('changeEmailSettings', 'API\UserAPIController@changeEmailSettings');

Route::resource('cuisines', 'API\CuisineAPIController');
Route::resource('categories', 'API\CategoryAPIController');
Route::post('restaurants/wordpress', 'API\RestaurantAPIController@wp_restaurant');
Route::resource('restaurants', 'API\RestaurantAPIController');

Route::resource('faq_categories', 'API\FaqCategoryAPIController');
Route::resource('foods', 'API\FoodAPIController');
Route::get('trending_foods', 'API\TrendAPIController@trending_foods');
Route::get('popular_foods', 'API\TrendAPIController@popular_foods');
Route::resource('galleries', 'API\GalleryAPIController');
Route::resource('food_reviews', 'API\FoodReviewAPIController');
Route::resource('nutrition', 'API\NutritionAPIController');
Route::resource('extras', 'API\ExtraAPIController');
Route::resource('extra_groups', 'API\ExtraGroupAPIController');
Route::resource('faqs', 'API\FaqAPIController');
Route::resource('restaurant_reviews', 'API\RestaurantReviewAPIController');
Route::resource('currencies', 'API\CurrencyAPIController');

Route::middleware('auth:api')->group(function () {
    Route::group(['middleware' => ['role:driver']], function () {
        Route::prefix('driver')->group(function () {
            Route::resource('orders', 'API\OrderAPIController');
            Route::resource('notifications', 'API\NotificationAPIController');
            Route::post('users/{id}', 'API\UserAPIController@update');
            Route::resource('faq_categories', 'API\FaqCategoryAPIController');
            Route::resource('faqs', 'API\FaqAPIController');
        });
    });
    Route::group(['middleware' => ['role:manager']], function () {
        Route::prefix('manager')->group(function () {
            
            Route::resource('drivers', 'API\DriverAPIController');

            Route::resource('earnings', 'API\EarningAPIController');

            Route::resource('driversPayouts', 'API\DriversPayoutAPIController');

            Route::resource('restaurantsPayouts', 'API\RestaurantsPayoutAPIController');


        });
    });

    /* Manager Routes */
    Route::get('manager/Home/{id}', 'API\Manager\HomeAPIController@show');
    Route::post('manager/SalesChart', 'API\Manager\TrendsAPIController@sales_chart');
    Route::get('manager/best_seller/{id}', 'API\Manager\TrendsAPIController@best_seller');
    Route::get('manager/show_cuisines/{id}', 'API\Manager\CuisineAPIController@show_all');
    Route::resource('manager/restaurants', 'API\Manager\RestaurantAPIController');
    /* --- */

    Route::post('users/{id}', 'API\UserAPIController@update');

    Route::get('order_statuses/get_order_status/{id}', 'API\OrderStatusAPIController@current_order_status');
    Route::get('order_statuses/all_orders_statuses', 'API\OrderStatusAPIController@user_orders');
    Route::resource('order_statuses', 'API\OrderStatusAPIController');

    Route::get('payments/byMonth', 'API\PaymentAPIController@byMonth')->name('payments.byMonth');
    Route::resource('payments', 'API\PaymentAPIController');

    Route::get('favorites/exist', 'API\FavoriteAPIController@exist');
    Route::resource('favorites', 'API\FavoriteAPIController');

    Route::resource('orders', 'API\OrderAPIController');

    Route::post('generate_order', 'API\GenerateOrderAPIController@order_payment');



    //Route::post('generate_payment', 'API\GenerateOrderAPIController@moneris_payment');

    Route::resource('food_orders', 'API\FoodOrderAPIController');

    Route::resource('notifications', 'API\NotificationAPIController');

    Route::get('carts/count', 'API\CartAPIController@count')->name('carts.count');
    Route::resource('carts', 'API\CartAPIController');

    Route::resource('delivery_addresses', 'API\DeliveryAddressAPIController');


});

Route::post('partner-register', 'CustomController@createPartner');