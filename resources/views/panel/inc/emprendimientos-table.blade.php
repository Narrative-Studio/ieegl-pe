@if($emprendimientos)

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Listado de mis Emprendimientos</h4>
                    <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="{{action('PanelEmprendimientos@DatosGenerales')}}" class="btn btn-success btn-sm"><i class="ft-plus white"></i> Nuevo Emprendimiento</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- Task List table -->
                        <div class="table-responsive">
                            <table id="project-bugs-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>% Completado </th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($emprendimientos as $item)
                                        <?php
                                            $porce = 0;
                                            if($item->module_datos==true) $porce ++;
                                            if($item->module_medios==true) $porce ++;
                                            if($item->module_mercado==true) $porce ++;
                                            if($item->module_financiera==true) $porce ++;
                                            if($item->module_inversion==true) $porce ++;
                                        ?>
                                    <tr>
                                        <td class="text-left">
                                            <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" class="text-bold-600">{{$item->nombre}}</a>
                                            <p class="text-muted font-small-2" style="white-space:normal;">{{$item->descripcion}}</p>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm">
                                                <div aria-valuemin="{{ ($porce/5)*100 }}" aria-valuemax="100" class="progress-bar bg-gradient-x-info" role="progressbar" style="width:{{ ($porce/5)*100 }}%" aria-valuenow="{{ ($porce/5)*100 }}"></div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($item->userKey==auth()->user()->_key)
                                                <span class="badge bg-blue-grey">Administrador</span>
                                            @else
                                                <span class="badge badge-primary">Socio</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->userKey == auth()->user()->_key)
                                                <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" class="btn btn-success btn-sm"><i class="fa fa-cog"></i> Editar</a>
                                            @else
                                                <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="bs-callout-warning callout-border-left p-1">
                <strong>No tienes emprendimientos</strong>
                <p>Aún no cuentas con emprendimientos. Anímate y <a href="{{action('PanelEmprendimientos@DatosGenerales')}}">agrega tu primer emprendimiento</a>.</p>
            </div>
        </div>
    </div>
@endif