<?php
Auth::routes();
Route::get('/', 'HomeController@Index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/restringido', 'HomeController@restringido')->name('restringido');
Route::get('/registro', 'HomeController@Register')->name('register');
Route::put('/registro', 'HomeController@RegisterSave');
Route::get('/confirmation/{token}', 'HomeController@Confirmation');

Route::get('/arango', 'TestController@Index');
Route::get('/test', 'HomeController@Test');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/panel', 'PanelController@Index')->name('dashboard');
});

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    Route::middleware('is_admin')->group(function () {
        Route::get('/', 'AdminController@Index')->name('admin.dashboard');
    });
});