<?php
Auth::routes();
Route::get('/', 'HomeController@Index');
Route::get('/acerca-de', 'HomeController@Acerca');
Route::get('/por-que-registrarme', 'HomeController@Porque');
Route::get('/aviso-de-privacidad', 'HomeController@Aviso');
Route::get('/terminos-y-condiciones', 'HomeController@Terminos');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/restringido', 'HomeController@restringido')->name('restringido');
Route::get('/registro', 'HomeController@Register')->name('register');
Route::put('/registro', 'HomeController@RegisterSave');
Route::get('/confirmation/{token}', 'HomeController@Confirmation');

Route::get('/arango', 'TestController@Index');

Route::prefix('panel')->group(function() {
    Route::middleware('auth')->group(function () {
        Route::get('/', 'PanelController@Index')->name('dashboard');

        /** Perfil **/
        Route::get('/perfil', 'PanelPerfiles@Index');
        Route::post('/perfil/savePersonales', 'PanelPerfiles@SaveDatosPersonales');
        Route::get('/perfil/estudios', 'PanelPerfiles@Estudios');
        Route::post('/perfil/saveEstudios', 'PanelPerfiles@SaveEstudios');
        Route::get('/perfil/cuenta', 'PanelPerfiles@Cuenta');
        Route::post('/perfil/saveCuenta', 'PanelPerfiles@SaveCuenta');

        /** Emprendimiento **/
        // Datos Generales
        Route::get('/emprendimientos/', 'PanelEmprendimientos@Index');
        Route::get('/emprendimientos/datosGenerales/{id?}', 'PanelEmprendimientos@DatosGenerales');
        Route::put('/emprendimientos/saveDatosGenerales', 'PanelEmprendimientos@SaveDatosGenerales');
        Route::get('/emprendimientos/search-socios', 'PanelEmprendimientos@SearchSocios');
        // Medios Digitales
        Route::get('/emprendimientos/mediosDigitales/{id}', 'PanelEmprendimientos@MediosDigitales');
        Route::post('/emprendimientos/saveMediosDigitales', 'PanelEmprendimientos@SaveMediosDigitales');
        // Ventas
        Route::get('/emprendimientos/ventas/{id}', 'PanelEmprendimientos@Ventas');
        Route::post('/emprendimientos/saveVentas', 'PanelEmprendimientos@SaveVentas');
        // Clientes
        Route::get('/emprendimientos/clientes/{id}', 'PanelEmprendimientos@Clientes');
        Route::post('/emprendimientos/saveClientes', 'PanelEmprendimientos@SaveClientes');
        // Usuarios
        Route::get('/emprendimientos/usuarios/{id}', 'PanelEmprendimientos@Usuarios');
        Route::post('/emprendimientos/saveUsuarios', 'PanelEmprendimientos@SaveUsuarios');
        // Inversion
        Route::get('/emprendimientos/inversion/{id}', 'PanelEmprendimientos@Inversion');
        Route::post('/emprendimientos/saveInversion', 'PanelEmprendimientos@SaveInversion');
        // Financiera
        Route::get('/emprendimientos/financiera/{id}', 'PanelEmprendimientos@Financiera');
        Route::post('/emprendimientos/saveFinanciera', 'PanelEmprendimientos@SaveFinanciera');
        // Final
        Route::get('/emprendimientos/final/{id}', 'PanelEmprendimientos@Final');

        /** Convocatorias **/
        Route::get('/convocatorias', 'PanelConvocatorias@Index');
        Route::get('/convocatorias/ver/{id}', 'PanelConvocatorias@Ver');
        Route::get('/convocatorias/ver-aplicacion/{id}', 'PanelConvocatorias@VerAplicacion');
        Route::get('/convocatorias/aplicaciones', 'PanelConvocatorias@Aplicaciones');
        Route::post('/convocatorias/aplicar/{id}', 'PanelConvocatorias@Aplicar');
        Route::post('/convocatorias/aplicando/{id}', 'PanelConvocatorias@Aplicacion');

        /** Actividades **/
        Route::get('/actividades', 'PanelActividades@Index');
        Route::post('/actividades/save', 'PanelActividades@Save');
        Route::get('/actividades/ver/{id}', 'PanelActividades@Ver');
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

        // Administradores
        Route::get('/administradores', 'AdminAdministradores@Index');
        Route::get('/administradores/new', 'AdminAdministradores@New');
        Route::get('/administradores/edit/{id}', 'AdminAdministradores@Edit');
        Route::post('/administradores/save', 'AdminAdministradores@Save');
        Route::get('/administradores/delete/{id}', 'AdminAdministradores@Delete');

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

        // Entidades
        Route::get('/entidades', 'AdminEntidades@Index');
        Route::get('/entidades/new', 'AdminEntidades@New');
        Route::get('/entidades/edit/{id}', 'AdminEntidades@Edit');
        Route::post('/entidades/save', 'AdminEntidades@Save');
        Route::get('/entidades/delete/{id}', 'AdminEntidades@Delete');

        // Quien Aplica
        Route::get('/quien', 'AdminQuien@Index');
        Route::get('/quien/new', 'AdminQuien@New');
        Route::get('/quien/edit/{id}', 'AdminQuien@Edit');
        Route::post('/quien/save', 'AdminQuien@Save');
        Route::get('/quien/delete/{id}', 'AdminQuien@Delete');

        // Convocatorias
        Route::get('/convocatoria', 'AdminConvocatorias@Index');
        Route::get('/convocatoria/new', 'AdminConvocatorias@New');
        Route::get('/convocatoria/edit/{id}', 'AdminConvocatorias@Edit');
        Route::post('/convocatoria/save', 'AdminConvocatorias@Save');
        Route::get('/convocatoria/delete/{id}', 'AdminConvocatorias@Delete');

        // Solicitudes
        Route::get('/solicitudes', 'AdminSolicitudes@Index');
        Route::get('/solicitudes/edit/{id}', 'AdminSolicitudes@Edit');
        Route::post('/solicitudes/save', 'AdminSolicitudes@Save');

        // Roles
        Route::get('/roles', 'AdminRoles@Index');
        Route::get('/roles/new', 'AdminRoles@New');
        Route::get('/roles/edit/{id}', 'AdminRoles@Edit');
        Route::post('/roles/save', 'AdminRoles@Save');
    });
});