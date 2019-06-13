<div class="form-group row">
    <label class="col-md-2 label-control">Nombre</label>
    <div class="col-md-10">
        <?php $class=($errors->has('nombre'))?'form-control error':'form-control'; ?>
        {!! Form::text('nombre', null, ['class' => $class]) !!}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 label-control">Permisos</label>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="form-group">
                    <i class="fa fa-users"></i> {{Form::label('', 'Usuarios')}}
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="usuarios" @if(in_array("usuarios", $permisos)) {{"checked='checked'"}} @endif> Usuarios</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="administradores" @if(in_array("administradores", $permisos)) {{"checked='checked'"}} @endif> Administradores</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="roles" @if(in_array("roles", $permisos)) {{"checked='checked'"}} @endif> Roles</label></div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="form-group">
                    <i class="fab fa-wpforms"></i> {{Form::label('', 'Catálogos')}}
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="convocatorias" @if(in_array("convocatorias", $permisos)) {{"checked='checked'"}} @endif> Convocatorias</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="universidades" @if(in_array("universidades", $permisos)) {{"checked='checked'"}} @endif> Universidades</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="industrias_y_sectores" @if(in_array("industrias_y_sectores", $permisos)) {{"checked='checked'"}} @endif> Industrias y Sectores</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="terminos_capital" @if(in_array("terminos_capital", $permisos)) {{"checked='checked'"}} @endif> Términos Capital</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="entidades" @if(in_array("entidades", $permisos)) {{"checked='checked'"}} @endif> Entidades</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="quien_aplica" @if(in_array("quien_aplica", $permisos)) {{"checked='checked'"}} @endif> Quien Aplica</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="preguntas_admin" @if(in_array("preguntas_admin", $permisos)) {{"checked='checked'"}} @endif> Preguntas</label></div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="form-group">
                    <i class="fa fa-database"></i> {{Form::label('', 'Aplicaciones')}}
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="solicitudes" @if(in_array("solicitudes", $permisos)) {{"checked='checked'"}} @endif> Aplicaciones</label></div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6">
                <div class="form-group">
                    <i class="fa fa-pie-chart"></i> {{Form::label('', 'Reportes')}}
                    <div class="checkbox"><label><input type="checkbox" name="permisos[]" value="reportes" @if(in_array("reportes", $permisos)) {{"checked='checked'"}} @endif> Reportes</label></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>