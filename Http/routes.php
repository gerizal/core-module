<?php
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('auth/login');
    }
});

/**
 * Authentication
 */
// Route::get('auth/login', 'Modules\Core\Http\Controllers\Core\Auth\LoginController@showLoginForm');
// Route::post('auth/login', 'Modules\Core\Http\Controllers\Core\Auth\LoginController@login');
// Route::get('auth/logout', 'Modules\Core\Http\Controllers\Core\Auth\LoginController@logout');

/**
 * Registration
 */
// Route::get('auth/register', 'Modules\Core\Http\Controllers\Core\Auth\RegisterController@showRegistrationForm');
// Route::post('auth/register', 'Modules\Core\Http\Controllers\Core\Auth\RegisterController@register');

/**
 * Password reset link request
 */
// Route::get('password/email', 'Modules\Core\Http\Controllers\Core\Auth\ForgotPasswordController@showLinkRequestForm');
// Route::post('password/email', 'Modules\Core\Http\Controllers\Core\Auth\ForgotPasswordController@sendResetLinkEmail');

/**
 * Password reset routes
 */
// Route::get('password/reset/{token}', 'Modules\Core\Http\Controllers\Core\Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Modules\Core\Http\Controllers\Core\Auth\ResetPasswordController@reset');

/**
 * Home
 */
// Route::get('/home', 'Modules\Core\Http\Controllers\Core\HomeController@index');

/**
 * Maintenance
 */
// Route::get('/maintenance', 'Modules\Core\Http\Controllers\Core\MaintenanceController@index');

/**
 * Users
 */
// Route::post('user/activate', [
//     'as' => 'user.activate',
//     'uses' => 'Modules\Core\Http\Controllers\Core\UserController@toggleActivate'
// ]);
// Route::post(
//     '/user/{user}/admin_reset_user_password',
//     'Modules\Core\Http\Controllers\Core\UserController@adminResetUserPassword'
// );
// Route::post(
//     '/user/{user}/admin_trash_user',
//     'Modules\Core\Http\Controllers\Core\UserController@adminTrashUser'
// );
// Route::get('/user/display', 'Modules\Core\Http\Controllers\Core\UserController@display');
// Route::resource('user', 'Modules\Core\Http\Controllers\Core\UserController');
// Route::bind('user', function ($value) {
//     $id = Hashids::decode($value)[0];
//     return Modules\Core\User::find($id);
// });

/**
 * User Levels
 */
Route::get('/user_level/display/{s?}', 'Modules\Core\Http\Controllers\Core\UserLevelController@display');
Route::resource('user_level', 'Modules\Core\Http\Controllers\Core\UserLevelController');
Route::bind('user_level', function ($value) {
    $id = Hashids::decode($value)[0];
    return Modules\Core\UserLevel::find($id);
});

/**
 * Profile
 */
Route::post(
    '/profile/{user}/confirm_delete_my_account',
    'Modules\Core\Http\Controllers\Core\ProfileController@confirmDeleteMyAccount'
);
Route::post(
    '/profile/{user}/update_avatar',
    'Modules\Core\Http\Controllers\Core\ProfileController@updateAvatar'
);
Route::get(
    '/profile/{user}/delete_my_account',
    'Modules\Core\Http\Controllers\Core\ProfileController@deleteMyAccount'
);
Route::resource('profile', 'Modules\Core\Http\Controllers\Core\ProfileController');
Route::bind('profile', function ($value) {
    $id = Hashids::decode($value)[0];
    return Modules\Core\User::find($id);
});

/**
 * Settings
 */
Route::resource('setting', 'Modules\Core\Http\Controllers\Core\SettingController');
Route::bind('setting', function ($value) {
    $id = Hashids::decode($value)[0];
    return Modules\Core\Setting::find($id);
});

/**
 * Appearance
 */
Route::resource('appearance', 'Modules\Core\Http\Controllers\Core\AppearanceController');
Route::bind('appearance', function ($value) {
    $id = Hashids::decode($value)[0];
    return Modules\Core\Appearance::find($id);
});

/**
 * Update application logo
 */
Route::any(
    '/update_application_logo',
    'Modules\Core\Http\Controllers\Core\SettingController@updateApplicationLogo'
);

/**
 * User integrations
 */
Route::resource('integration', 'Modules\Core\Http\Controllers\Core\UserIntegrationController');
Route::bind('integration', function ($value) {
    $id = Hashids::decode($value)[0];
    return Modules\Core\UserIntegration::find($id);
});

/**
 * Features
 */
Route::get('/feature/display/{s?}', 'Modules\Core\Http\Controllers\Core\FeatureController@display');
Route::resource('feature', 'Modules\Core\Http\Controllers\Core\FeatureController');
Route::bind('feature', function ($value) {
    $id = Hashids::decode($value)[0];
    return Modules\Core\Feature::find($id);
});

/**
 * Handle assets
 */
Route::get('cwa_css/{cwa_module}/{file}', function ($cwa_module, $file) {
    $ext = substr($file, -3);
    if ($ext == 'off' || $ext == 'ttf') {
        $response = Response::make(
            file_get_contents(
                base_path().'/vendor/gerizal/core-module/Assets/AdminLTE/fonts/'.$file
            )
        );
        $response->header('Content-Type', 'font/opentype');
        return $response;
    }

    $response = Response::make(
        file_get_contents(
            base_path().'/vendor/gerizal/'.$cwa_module.'-module/Assets/AdminLTE/css/'.str_replace('&', '/', $file)
        )
    );
    $response->header('Content-Type', 'text/css');
    return $response;
});

Route::get('cwa_js/{cwa_module}/{file}', function ($cwa_module, $file) {
    $response = Response::make(
        file_get_contents(
            base_path().'/vendor/gerizal/'.$cwa_module.'-module/Assets/AdminLTE/js/'.$file
        )
    );
    $response->header('Content-Type', 'text/javascript');
    return $response;
});

Route::get('cwa_img/{cwa_module}/{file}', function ($cwa_module, $file) {
    $response = Response::make(
        file_get_contents(
            base_path().'/vendor/gerizal/'.$cwa_module.'-module/Assets/AdminLTE/img/'.$file
        )
    );
    $response->header('Content-Type', 'text/css');
    return $response;
});

Route::get('cwa_plugin/{cwa_module}/{file}', function ($cwa_module, $file) {
    if ($file == 'blue.png') {
        $response = Response::make(
            file_get_contents(
                base_path().'/vendor/gerizal/'.$cwa_module.'-module/Assets/AdminLTE/plugins/iCheck/square/'.$file
            )
        );
        return $response;
    }

    $response = Response::make(
        @file_get_contents(
            base_path().'/vendor/gerizal/'.$cwa_module.'-module/Assets/AdminLTE/plugins/'.str_replace('&', '/', $file)
        )
    );

    $ext = substr($file, -3);
    if ($ext == 'css') {
        $response->header('Content-Type', 'text/css');
    } else {
        $response->header('Content-Type', 'text/javascript');
    }

    return $response;
});
