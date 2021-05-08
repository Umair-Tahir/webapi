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

/* Controllers currently not working */
Route::post('sendInvoice/{id}', 'API\OrderAPIController@generateInvoice');
Route::post('partner-register', 'CustomController@createPartner');
/* *********************** */




/* ************* Protected Routes  ************* */
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
            /*Live Manager Routes */
            Route::get('Home/{id}', 'API\Manager\HomeAPIController@show');
            Route::get('SalesChart/{days}', 'API\Manager\TrendsAPIController@sales_chart');
            Route::get('best_seller/{id}', 'API\Manager\TrendsAPIController@best_seller');
            Route::get('show_cuisines/{id}', 'API\Manager\CuisineAPIController@show_all');
            Route::get('showRestaurants', 'API\Manager\RestaurantAPIController@showRestaurants');
            Route::resource('restaurants', 'API\Manager\RestaurantAPIController');
            /* --- */

            Route::resource('earnings', 'API\EarningAPIController');



        });
    });
    /* ***************************************   *************************************** */

    /* Local Manager Routes */
    Route::get('manager/Home/{id}', 'API\Manager\HomeAPIController@show');
    Route::get('manager/SalesChart/{days}', 'API\Manager\TrendsAPIController@sales_chart');
    Route::get('manager/best_seller/{id}', 'API\Manager\TrendsAPIController@best_seller');
    Route::get('manager/show_cuisines/{id}', 'API\Manager\CuisineAPIController@show_all');
    Route::get('manager/showRestaurants', 'API\Manager\RestaurantAPIController@showRestaurants');
    Route::resource('manager/restaurants', 'API\Manager\RestaurantAPIController');
    /* --- */


    /* ************* Cuisines ************* */
    Route::resource('cuisines', 'API\CuisineAPIController');
    /* *************  ************* */

    /* ************* Categories ************* */
    Route::resource('categories', 'API\CategoryAPIController');
    /* *************  ************* */

    /* ************* Delivery Addresses ************* */
    Route::resource('delivery_addresses', 'API\DeliveryAddressAPIController');
    /* *************  ************* */

    /* ************* EVA Delivery Service Availability ,Get Quote ,Call Ride ************* */
    Route::post('delivery_service/service_availability', 'API\DeliveryService\EvaAPIController@serviceAvailability');
    Route::post('delivery_service/get_quote', 'API\DeliveryService\EvaAPIController@getQuote');
    Route::post('delivery_service/call_ride', 'API\DeliveryService\EvaAPIController@callRide');
    Route::post('delivery_service/restaurant_call_ride', 'API\DeliveryService\EvaAPIController@restaurantCallRide');

    /* *************  ************* */

    /* ************* Restaurants ************* */
    Route::resource('restaurants', 'API\RestaurantAPIController');
    /* *************  ************* */

    /* *************  Extras ************* */
    Route::resource('extras', 'API\ExtraAPIController');
    /* *************  ************* */

    /* ************* Extras Groups ************* */
    Route::resource('extra_groups', 'API\ExtraGroupAPIController');
    /* *************   ************* */

    /* *************  FAQ ************* */
    Route::resource('faqs', 'API\FaqAPIController');
    /* *************  ************* */

    /* *************  Faq Categories ************* */
    Route::resource('faq_categories', 'API\FaqCategoryAPIController');
    /* *************   ************* */

    /* ************ Favorites *********** */
    Route::get('favorites/exist', 'API\FavoriteAPIController@exist');
    Route::resource('favorites', 'API\FavoriteAPIController');
    /* *************   ************* */

    /* *************  Foods ************* */
    Route::resource('foods', 'API\FoodAPIController');
    /* *************   ************* */

    /* *************  Foods Orders ************* */
    Route::resource('food_orders', 'API\FoodOrderAPIController');
    /* *************   ************* */

    /* *************  Food Reviews ************* */
    Route::resource('food_reviews', 'API\FoodReviewAPIController');
    /* *************  ************* */

    /* ************ Generate Orders *********** */
    Route::post('order/pickup', 'API\GenerateOrderAPIController@pickupOrder');
    Route::post('order/eva_ds', 'API\GenerateOrderAPIController@deliveryServiceOrder');
    Route::post('order/restaurant_delivery', 'API\GenerateOrderAPIController@restaurantDeliveryOrder');
    Route::post('order/eva_delivery', 'API\GenerateOrderAPIController@deliveryServiceOrder');
    Route::post('order/restaurant_delivery', 'API\GenerateOrderAPIController@restaurantDeliveryOrder');
    /* *************   ************* */

    /* ************ Notifications *********** */
    Route::resource('notifications', 'API\NotificationAPIController');
    /* *************   ************* */

    /* ************ Orders *********** */
    Route::resource('orders', 'API\OrderAPIController');
    /* *************   ************* */

    /* ************ Order Statuses *********** */
    Route::get('orderStatuses/getOrderStatus/{id}', 'API\OrderStatusAPIController@currentOrderStatus');
    Route::get('orderStatuses/allOrdersStatuses', 'API\OrderStatusAPIController@userOrders');
    Route::resource('orderStatuses', 'API\OrderStatusAPIController');
    /* *************   ************* */


    /* *************  Popular Foods ************* */
    Route::get('popular_foods', 'API\TrendAPIController@popular_foods');
    /* *************   ************* */

    /* *************  Restaurant Reviews ************* */
    Route::resource('restaurant_reviews', 'API\RestaurantReviewAPIController');
    /* *************   ************* */

    /* *************  Trending_Foods ************* */
    Route::get('trending_foods', 'API\TrendAPIController@trendingFoods');
    /* *************   ************* */


    /* *************  Resend OTP ************* */
    Route::get('reset_otp', 'API\Manager\UserAPIController@reset_otp');
    /* *************   ************* */


    /* *************  Verify Phone ************* */
    Route::post('phone_verify', 'API\Manager\UserAPIController@phoneVerify');
    /* *************   ************* */

});

/* ************************ Public routes *********************** */

//Manager public routes
Route::prefix('manager')->group(function () {
    Route::post('login', 'API\Manager\UserAPIController@login');
    Route::post('register', 'API\Manager\UserAPIController@register');
    Route::get('user', 'API\Manager\UserAPIController@user');
    Route::get('logout', 'API\Manager\UserAPIController@logout');
});

/* ******* User ************* */
Route::post('login', 'API\UserAPIController@login');
Route::post('register', 'API\UserAPIController@register');
Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
Route::get('user', 'API\UserAPIController@user');
Route::get('logout', 'API\UserAPIController@logout');
Route::get('settings', 'API\UserAPIController@settings');
Route::post('changeEmailSettings', 'API\UserAPIController@changeEmailSettings');
/* ******************************* */

/* ************ Wordpress *********** */
Route::post('restaurants/wordpress', 'API\RestaurantAPIController@wp_restaurant');
/* *********************** */