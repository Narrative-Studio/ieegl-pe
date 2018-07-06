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

Route::prefix('panel')->group(function() {
    Route::middleware('auth')->group(function () {
        Route::get('/', 'PanelController@Index')->name('dashboard');

        // Perfil
        Route::get('/perfil', 'PanelPerfiles@Index');
        Route::post('/perfil/savePersonales', 'PanelPerfiles@SaveDatosPersonales');
        Route::get('/perfil/estudios', 'PanelPerfiles@Estudios');
        Route::post('/perfil/saveEstudios', 'PanelPerfiles@SaveEstudios');
        Route::get('/perfil/cuenta', 'PanelPerfiles@Cuenta');
        Route::post('/perfil/saveCuenta', 'PanelPerfiles@SaveCuenta');

        /** Emprendimiento **/
        // Datos Generales
        Route::get('/emprendimientos/datosGenerales/{id?}', 'PanelEmprendimientos@DatosGenerales');
        Route::put('/emprendimientos/saveDatosGenerales', 'PanelEmprendimientos@SaveDatosGenerales');
        Route::get('/emprendimientos/search-socios', 'PanelEmprendimientos@SearchSocios');
        // Medios Digitales
        Route::get('/emprendimientos/mediosDigitales/{id}', 'PanelEmprendimientos@MediosDigitales');
        Route::post('/emprendimientos/saveMediosDigitales', 'PanelEmprendimientos@SaveMediosDigitales');
        // Ventas
        Route::get('/emprendimientos/ventas/{id}', 'PanelEmprendimientos@Ventas');
        Route::post('/emprendimientos/saveVentas', 'PanelEmprendimientos@SaveVentas');
    });
});

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    Route::middleware('is_admin')->group(function () {
        Route::get('/', 'AdminController@Index')->name('admin.dashboard');

        // Usuarios
        Route::get('/users', 'AdminUsuarios@Index');
        Route::get('/users/edit/{id}', 'AdminUsuarios@Edit');
        Route::post('/users/save', 'AdminUsuarios@Save');
        Route::get('/users/delete/{id}', 'AdminUsuarios@Delete');

        // Universidades
        Route::get('/universidades', 'AdminUniversidades@Index');
        Route::get('/universidades/new', 'AdminUniversidades@New');
        Route::get('/universidades/edit/{id}', 'AdminUniversidades@Edit');
        Route::post('/universidades/save', 'AdminUniversidades@Save');
        Route::get('/universidades/delete/{id}', 'AdminUniversidades@Delete');

        // Industrias
        Route::get('/industrias', 'AdminIndustrias@Index');
        Route::get('/industrias/new', 'AdminIndustrias@New');
        Route::get('/industrias/edit/{id}', 'AdminIndustrias@Edit');
        Route::post('/industrias/save', 'AdminIndustrias@Save');
        Route::get('/industrias/delete/{id}', 'AdminIndustrias@Delete');

        // Etapas
        Route::get('/etapas', 'AdminEtapas@Index');
        Route::get('/etapas/new', 'AdminEtapas@New');
        Route::get('/etapas/edit/{id}', 'AdminEtapas@Edit');
        Route::post('/etapas/save', 'AdminEtapas@Save');
        Route::get('/etapas/delete/{id}', 'AdminEtapas@Delete');

        // Terminos
        Route::get('/terminos', 'AdminTerminos@Index');
        Route::get('/terminos/new', 'AdminTerminos@New');
        Route::get('/terminos/edit/{id}', 'AdminTerminos@Edit');
        Route::post('/terminos/save', 'AdminTerminos@Save');
        Route::get('/terminos/delete/{id}', 'AdminTerminos@Delete');

    });
});