@if($emprendimientos)
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="bg-primary white">
            <tr>
                <th>Fecha de fundación</th>
                <th>Nombre</th>
                <th>Nivel</th>
                <th>Datos Grales.</th>
                <th>Medios Digitales</th>
                <th>Ventas</th>
                <th>Clientes</th>
                <th>Información Finaciera</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($emprendimientos as $item)
                <tr>
                    <td style="text-transform: capitalize;">{{\Illuminate\Support\Carbon::parse($item->fecha_fundacion)->formatLocalized('%d %B %Y')}}</td>
                    <td>{{$item->nombre}}</td>
                    <td>{{$niveles[$item->nivel_tlr]}}</td>
                    <td class="text-center">@if($item->module_datos==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_medios==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_ventas==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_clientes==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
                    <td class="text-center">@if($item->module_financiera==true) <i class="fa fa-check-circle success"></i> @else <i class="fa fa-times-circle" style="color: #999;"></i> @endif</td>
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