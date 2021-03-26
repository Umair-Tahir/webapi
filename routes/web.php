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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

//    they can receive directly to POS


    return "Cache is cleared";
});

Route::get('/run-migrations', function () {
    return Artisan::call('migrate', ["--force" => true ]);
});

Route::get('run-seeder/{class}',function($class){
    return Artisan::call("db:seed",array("--force" => true,'--class'=>$class));
});

Route::get('payments/paypal/express-checkout', 'PayPalController@getExpressCheckout')->name('paypal.express-checkout');
Route::get('payments/paypal/express-checkout-success', 'PayPalController@getExpressCheckoutSuccess');
Route::get('payments/paypal', 'PayPalController@index')->name('paypal.index');

Route::get('verify-account', 'CustomController@verify');

Route::get('firebase/sw-js', 'AppSettingController@initFirebase');

Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('storage/app/public/{id}/{conversion}/{filename?}', 'UploadController@storage');
Route::middleware('auth')->group(function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/', 'UserController@profile')->name('users.profile');

    Route::post('uploads/store', 'UploadController@store')->name('medias.create');
    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/remove-media', 'UserController@removeMedia');
    Route::resource('users', 'UserController');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['middleware' => ['permission:medias']], function () {
        Route::get('uploads/all/{collection?}', 'UploadController@all');
        Route::get('uploads/collectionsNames', 'UploadController@collectionsNames');
        Route::post('uploads/clear', 'UploadController@clear')->name('medias.delete');
        Route::get('medias', 'UploadController@index')->name('medias');
        Route::get('uploads/clear-all', 'UploadController@clearAll');
    });

    Route::group(['middleware' => ['permission:permissions.index']], function () {
        Route::get('permissions/role-has-permission', 'PermissionController@roleHasPermission');
        Route::get('permissions/refresh-permissions', 'PermissionController@refreshPermissions');
    });
    Route::group(['middleware' => ['permission:permissions.index']], function () {
        Route::post('permissions/give-permission-to-role', 'PermissionController@givePermissionToRole');
        Route::post('permissions/revoke-permission-to-role', 'PermissionController@revokePermissionToRole');
    });

    Route::group(['middleware' => ['permission:app-settings']], function () {
        Route::prefix('settings')->group(function () {
            Route::resource('permissions', 'PermissionController');
            Route::resource('roles', 'RoleController');
            Route::resource('customFields', 'CustomFieldController');
            Route::post('users/remove-media', 'UserController@removeMedia');
            Route::get('users/login-as-user/{id}', 'UserController@loginAsUser')->name('users.login-as-user');
            Route::patch('update', 'AppSettingController@update');
            Route::patch('translate', 'AppSettingController@translate');
            Route::get('sync-translation', 'AppSettingController@syncTranslation');
            Route::get('clear-cache', 'AppSettingController@clearCache');
            Route::get('check-update', 'AppSettingController@checkForUpdates');
            // disable special character and number in route params
            Route::get('/{type?}/{tab?}', 'AppSettingController@index')
                ->where('type', '[A-Za-z]*')->where('tab', '[A-Za-z]*')->name('app-settings');
        });
    });

    Route::post('cuisines/remove-media', 'CuisineController@removeMedia');
    Route::resource('cuisines', 'CuisineController')->except([
        'show'
    ]);

    Route::post('restaurants/remove-media', 'RestaurantController@removeMedia');
    Route::resource('restaurants', 'RestaurantController')->except([
        'show'
    ]);

    Route::post('categories/remove-media', 'CategoryController@removeMedia');
    Route::resource('categories', 'CategoryController')->except([
        'show'
    ]);

    Route::resource('faqCategories', 'FaqCategoryController')->except([
        'show'
    ]);

    Route::resource('orderStatuses', 'OrderStatusController')->except([
        'create', 'store', 'destroy'
    ]);;

    Route::post('foods/remove-media', 'FoodController@removeMedia');
    Route::resource('foods', 'FoodController')->except([
        'show'
    ]);

    Route::post('galleries/remove-media', 'GalleryController@removeMedia');
    Route::resource('galleries', 'GalleryController')->except([
        'show'
    ]);

    Route::resource('foodReviews', 'FoodReviewController')->except([
        'show'
    ]);


    Route::resource('nutrition', 'NutritionController')->except([
        'show'
    ]);

    Route::post('extras/remove-media', 'ExtraController@removeMedia');
    Route::resource('extras', 'ExtraController');

    Route::resource('payments', 'PaymentController')->except([
        'create', 'store', 'edit', 'destroy'
    ]);;

    Route::resource('faqs', 'FaqController')->except([
        'show'
    ]);
    Route::resource('restaurantReviews', 'RestaurantReviewController')->except([
        'show'
    ]);

    Route::resource('favorites', 'FavoriteController')->except([
        'show'
    ]);

    Route::resource('orders', 'OrderController');

    Route::resource('notifications', 'NotificationController')->except([
        'create', 'store', 'update', 'edit',
    ]);;

    Route::resource('carts', 'CartController')->except([
        'show', 'store', 'create'
    ]);
    Route::resource('currencies', 'CurrencyController')->except([
        'show'
    ]);
    Route::resource('deliveryAddresses', 'DeliveryAddressController')->except([
        'show'
    ]);



    Route::resource('earnings', 'EarningController')->except([
        'show', 'edit', 'update'
    ]);


    Route::resource('restaurantsPayouts', 'RestaurantsPayoutController')->except([
        'show', 'edit', 'update'
    ]);

    Route::resource('extraGroups', 'ExtraGroupController')->except([
        'show'
    ]);

    Route::post('extras/remove-media', 'ExtraController@removeMedia');

    Route::resource('extras', 'ExtraController')->except([
        'show'
    ]);
});