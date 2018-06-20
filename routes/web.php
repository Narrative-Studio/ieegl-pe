<?php
Auth::routes();
Route::get('/', 'HomeController@Index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/restringido', 'HomeController@restringido')->name('restringido');

Route::get('/arango', 'TestController@Create');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/panel', 'PanelController@Index')->name('dashboard');
});

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    Route::middleware('is_admin')->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
    });
});