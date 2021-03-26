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
/*************************/



<<<<<<< HEAD
=======
//Client Routes


Route::prefix('client')->group(function () {
    Route::post('login', 'API\Client\UserAPIController@login');
    Route::post('register', 'API\Client\UserAPIController@register');
    Route::get('user', 'API\Client\UserAPIController@user');
    Route::get('logout', 'API\Client\UserAPIController@logout');
    Route::get('settings', 'API\Client\UserAPIController@settings');
    Route::post('phone_verify', 'API\Client\UserAPIController@phoneVerify');

});

>>>>>>> 096f740642067f560d0f6ffc6754e3752fc69f97

//Manager public routes
Route::prefix('manager')->group(function () {
    Route::post('login', 'API\Manager\UserAPIController@login');
    Route::post('register', 'API\Manager\UserAPIController@register');
    Route::get('user', 'API\Manager\UserAPIController@user');
    Route::get('logout', 'API\Manager\UserAPIController@logout');
});

/* User */
Route::post('login', 'API\UserAPIController@login');
Route::post('register', 'API\UserAPIController@register');
Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
Route::get('user', 'API\UserAPIController@user');
Route::get('logout', 'API\UserAPIController@logout');
Route::get('settings', 'API\UserAPIController@settings');
Route::post('changeEmailSettings', 'API\UserAPIController@changeEmailSettings');
/*********************************/

Route::resource('cuisines', 'API\CuisineAPIController');

Route::resource('categories', 'API\CategoryAPIController');

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
            /*Live Manager Routes */
            Route::get('Home/{id}', 'API\Manager\HomeAPIController@show');
            Route::get('SalesChart/{days}', 'API\Manager\TrendsAPIController@sales_chart');
            Route::get('best_seller/{id}', 'API\Manager\TrendsAPIController@best_seller');
            Route::get('show_cuisines/{id}', 'API\Manager\CuisineAPIController@show_all');
            Route::get('showRestaurants', 'API\Manager\RestaurantAPIController@showRestaurants');
            Route::resource('restaurants', 'API\Manager\RestaurantAPIController');
            /* --- */

<<<<<<< HEAD
            Route::resource('drivers', 'API\DriverAPIController');
=======

            Route::resource('drivers', 'API\ClientAPIController');
>>>>>>> 096f740642067f560d0f6ffc6754e3752fc69f97

            Route::resource('earnings', 'API\EarningAPIController');

            Route::resource('driversPayouts', 'API\ClientsPayoutAPIController');

            Route::resource('restaurantsPayouts', 'API\RestaurantsPayoutAPIController');

        });
    });

    /* Local Manager Routes */
    Route::get('manager/Home/{id}', 'API\Manager\HomeAPIController@show');
    Route::get('manager/SalesChart/{days}', 'API\Manager\TrendsAPIController@sales_chart');
    Route::get('manager/best_seller/{id}', 'API\Manager\TrendsAPIController@best_seller');
    Route::get('manager/show_cuisines/{id}', 'API\Manager\CuisineAPIController@show_all');
    Route::get('manager/showRestaurants', 'API\Manager\RestaurantAPIController@showRestaurants');
    Route::resource('manager/restaurants', 'API\Manager\RestaurantAPIController');
    /* --- */

    Route::post('users/{id}', 'API\UserAPIController@update');

    /************* Order Statuses ************/
    Route::get('orderStatuses/getOrderStatus/{id}', 'API\OrderStatusAPIController@currentOrderStatus');
    Route::get('orderStatuses/allOrdersStatuses', 'API\OrderStatusAPIController@userOrders');
    Route::resource('orderStatuses', 'API\OrderStatusAPIController');
    /************* Payments ************/
    Route::get('payments/byMonth', 'API\PaymentAPIController@byMonth')->name('payments.byMonth');
    Route::resource('payments', 'API\PaymentAPIController');
    /************* Favorites ************/
    Route::get('favorites/exist', 'API\FavoriteAPIController@exist');
    Route::resource('favorites', 'API\FavoriteAPIController');
    /************* Orders ************/
    Route::resource('orders', 'API\OrderAPIController');

    Route::post('generate_order', 'API\GenerateOrderAPIController@order_payment');

    //Route::post('generate_payment', 'API\GenerateOrderAPIController@moneris_payment');

    Route::resource('food_orders', 'API\FoodOrderAPIController');

    Route::resource('notifications', 'API\NotificationAPIController');

    Route::get('carts/count', 'API\CartAPIController@count')->name('carts.count');
    Route::resource('carts', 'API\CartAPIController');

    Route::resource('delivery_addresses', 'API\DeliveryAddressAPIController');

});

/************* Wordpress ************/
Route::post('restaurants/wordpress', 'API\RestaurantAPIController@wp_restaurant');
/*************************/
Route::post('partner-register', 'CustomController@createPartner');