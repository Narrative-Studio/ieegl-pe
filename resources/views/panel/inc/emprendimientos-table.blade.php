@if($emprendimientos)
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="bg-primary white">
            <tr>
                <th>Nombre</th>
                <th>Nivel</th>
                <th>Grales.</th>
                <th>Medios Dig.</th>
                <th>Clientes</th>
                <th>Usuarios</th>
                <th>Inversión</th>
                <th>Inf. Finaciera</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($emprendimientos as $item)
                <tr>
                    <td>{{$item->nombre}}</td>
                    <td>@if(isset($item->nivel_tlr)){{$niveles[$item->nivel_tlr]}}@else <i>No aplica</i> @endif</td>
                    <td class="text-center">@if($item->module_datos==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_medios==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_clientes==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_usuarios==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_financiera==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_inversion==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td>
                        <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" class="btn btn-sm btn-info mr-1"><i class="fa fa-edit"></i> Ver/Editar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="bs-callout-warning callout-border-left p-1">
                <strong>No tienes emprendimientos</strong>
                <p>Aún no cuentas con emprendimientos. Anímate y <a href="{{action('PanelEmprendimientos@DatosGenerales')}}">agrega tu primer emprendimiento</a>.</p>
            </div>
        </div>
    </div>
    </div>
@endif