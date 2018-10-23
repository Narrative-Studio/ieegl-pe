@extends('layouts.admin')

@section('titulo') Reportes @endsection
@section('seccion') Reportes @endsection
@section('accion') Emprendimientos Full @endsection

@section('js')
    <script type="text/javascript">
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <table id="dataTable"
                                        data-pagination="true"
                                        data-side-pagination="server"
                                        data-search="true"
                                        data-page-size="50"
                                        data-toggle="table"
                                        data-show-export="true"
                                        data-show-columns="true"
                                        data-sort-name="nombre"
                                        data-sort-order="asc"
                                        data-url="{{route('reportes.emprendimientosFull')}}"
                                        data-page-list="[50, 100, Unlimited]"
                                        class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th data-sortable="true" data-field="_key">ID</th>
                                        <th data-sortable="true" data-field="emprendimiento">Emprendimiento</th>
                                        <th data-field="descripcion">Descripción</th>
                                        <th data-field="usuario">Usuario</th>
                                        <th data-field="email">Email</th>
                                        <th data-field="telefono">Teléfono</th>
                                        <th data-field="convocatoria">Convocatoria</th>
                                        <th data-field="numero_colaboradores">Colaboradores</th>
                                        <th data-field="logo_file">Logotipo</th>
                                        <th data-field="pais">País</th>
                                        <th data-field="ciudad">Ciudad</th>
                                        <th data-field="industria_o_sector">Industrias</th>
                                        <th data-field="etapa_emprendimiento">Etapa</th>
                                        <th data-field="mercado_cliente">Mercado</th>
                                        <th data-field="problema_soluciona">Problema</th>
                                        <th data-field="competencia">Competencia</th>
                                        <th data-field="diferencia_competencia">Diferenciación Competencia</th>
                                        <th data-field="diferenciador_modelo_negocio">Diferenciación Modelo de Negocio</th>
                                        <th data-field="prototipo_o_mvp">¿MVP?</th>
                                        <th data-field="investigacion_desarrollo">¿Proceso de Investigación?</th>
                                        <th data-field="numero_socios"># de Socios Fundadores</th>
                                        <th data-field="nivel_tlr">Nivel de TLR</th>
                                        <th data-field="socios">Nombres de Socios</th>
                                        <th data-field="como_te_enteraste">¿Cómo te enteraste?</th>
                                        <th data-field="como_te_enteraste_cual">¿Cuál?</th>
                                        <th data-field="sitio_web">Sitio Web</th>
                                        <th data-field="red_social">Red Social más utilizada</th>
                                        <th data-field="video">Liga Video</th>
                                        <th data-field="tiene_clientes">¿Clientes?</th>
                                        <th data-field="caracteristicas_clientes">3 Características de Clientes</th>
                                        <th data-field="clientes_activos">Clientes Activos</th>
                                        <th data-field="clientes_mes1">Clientes Mes 1</th>
                                        <th data-field="clientes_mes2">Clientes Mes 2</th>
                                        <th data-field="clientes_mes3">Clientes Mes 3</th>
                                        <th data-field="tiene_usuarios">¿Usuarios?</th>
                                        <th data-field="caracteristicas_usuarios">3 Características de Usuarios</th>
                                        <th data-field="usuarios_activos">Usuarios Activos</th>
                                        <th data-field="usuarios_mes1">Usuarios Mes 1</th>
                                        <th data-field="usuarios_mes2">Usuarios Mes 2</th>
                                        <th data-field="usuarios_mes1">Usuarios Mes 3</th>
                                        <th data-field="socios_operadores">Usuarios</th>
                                        <th data-field="capital">¿Inversión Capital Socios Operadores?</th>
                                        <th data-field="levantado_capital">¿Levantado Capital?</th>
                                        <th data-field="recibido_inversion">¿Recibido Inversión</th>
                                        <th data-field="recibido_inversion_dequien">¿De quién?</th>
                                        <th data-field="recibido_inversion_cuanto">¿Cuánto?</th>
                                        <th data-field="recibido_inversion_como">¿Cómo?</th>
                                        <th data-field="recibido_inversion_fecha_levantaron_capital">Fecha último levantamiento</th>
                                        <th data-field="recibido_inversion_vehiculo">Vehículo de inversión</th>
                                        <th data-field="buscando_capital">Actualmente buscas capital?</th>
                                        <th data-field="capital_cuanto">¿Cuanto?</th>
                                        <th data-field="vehiculo_inversion">¿Con que vehículo?</th>
                                        <th data-field="fecha_fundacion">Fecha de fundación</th>
                                        <th data-field="lanzar_producto">¿Ya lanzaste?</th>
                                        <th data-field="fecha_lanzamiento">Fecha lanzamiento</th>
                                        <th data-field="patente_ip">¿Patente o IP?</th>
                                        <th data-field="modelo_ventas">¿Modelo de Ventas</th>
                                        <th data-field="realizado_ventas">¿Has tenido ventas?</th>
                                        <th data-field="ventas_mes1">Ventas Mes 1</th>
                                        <th data-field="ventas_mes2">Ventas Mes 2</th>
                                        <th data-field="ventas_mes3">Ventas Mes 3</th>
                                        <th data-field="gasto_mensual">Gasto Mensual</th>
                                        <th data-field="pierde_dinero">¿Cuánto pierde?</th>
                                        <th data-field="socio_exit_empresa">¿Exit de Socios?</th>
                                        <th data-field="biografia">Biografía</th>
                                        <th data-field="sexo">Sexo</th>
                                        <th data-field="fecha_nacimiento">Fecha de Nacimiento</th>
                                        <th data-field="a_que_se_dedica">Se dedica a</th>
                                        <th data-field="linkedin">Linkedin</th>
                                        <th data-field="universidad">Universidad</th>
                                        <th data-field="campus">Campus</th>
                                        <th data-field="universidad_otra">Otra Universidad</th>
                                        <th data-field="actualmente_cursando_carrera">Cursando Carrera</th>
                                        <th data-field="fecha_graduacion">Fecha Graduación</th>
                                        <th data-field="matricula">Matrícula</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
