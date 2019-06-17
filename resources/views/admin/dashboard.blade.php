@extends('layouts.admin')

@section('js')
    <script src="{{url("/")}}/app-assets/vendors/js/extensions/jquery.knob.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/morris.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/chartist.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/chartist-plugin-tooltip.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/chart.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/extensions/underscore-min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/extensions/clndr.min.js"></script>
    <script src="{{url("/")}}/app-assets/vendors/js/extensions/unslider-min.js"></script>    
    <script src="{{url("/")}}/app-assets/js/scripts/pages/dashboard-project.js"></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- project stats -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                    <div class="p-1 text-center">
                                        <div>
                                            <h3 class="font-large-1 grey darken-1 text-bold-400">{{$dashboard->usuarios->total}}</h3>
                                            <span class="font-small-3 grey darken-1">Usuarios</span>
                                        </div>
                                        <div class="card-content mt-1">
                                            <ul class="list-inline clearfix mb-0">
                                                <li class="border-right-grey border-right-lighten-2 pr-2">
                                                    <h3 class="success text-bold-400">{{$dashboard->usuarios->dia}}</h3>
                                                    <span class="font-small-3 grey darken-1">Hoy</span>
                                                </li>
                                                <li class="pl-2">
                                                    <h3 class="success text-bold-400">{{$dashboard->usuarios->mes}}</h3>
                                                    <span class="font-small-3 grey darken-1">Último Mes</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                    <div class="p-1 text-center">
                                        <div>
                                            <h3 class="font-large-1 grey darken-1 text-bold-400">{{$dashboard->empre->total}}</h3>
                                            <span class="font-small-3 grey darken-1">Emprendimientos</span>
                                        </div>
                                        <div class="card-content mt-1">
                                            <ul class="list-inline clearfix mb-0">
                                                <li class="border-right-grey border-right-lighten-2 pr-2">
                                                    <h3 class="primary text-bold-400">{{$dashboard->empre->dia}}</h3>
                                                    <span class="font-small-3 grey darken-1">Hoy</span>
                                                </li>
                                                <li class="pl-2">
                                                    <h3 class="primary text-bold-400">{{$dashboard->empre->mes}}</h3>
                                                    <span class="font-small-3 grey darken-1">Último Mes</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="p-1 text-center">
                                        <div>
                                            <h3 class="font-large-1 grey darken-1 text-bold-400">{{$dashboard->convo->total}}</h3>
                                            <span class="font-small-3 grey darken-1">Convocatorias</span>
                                        </div>
                                        <div class="card-content mt-1">
                                            <ul class="list-inline clearfix mb-0">
                                                <li class="border-right-grey border-right-lighten-2 pr-2">
                                                    <h3 class="danger text-bold-400">{{$dashboard->convo->dia}}</h3>
                                                    <span class="font-small-3 grey darken-1"> Hoy</span>
                                                </li>
                                                <li class="pl-2">
                                                    <h3 class="danger text-bold-400">{{$dashboard->convo->mes}}</h3>
                                                    <span class="font-small-3 grey darken-1">Último Mes</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ project stats -->


            <!--project health, featured & chart-->
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <div class="card-header">
                                    <span class="success darken-1">Total de Aplicaciones</span>
                                    <h3 class="font-large-2 grey darken-1 text-bold-200">{{$dashboard->apps->total}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a href="{{action('AdminConvocatorias@New')}}">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 bg-success text-white media-body text-left rounded-left">
                                        <h5 class="text-white text-bold-400 mt-1">Crear Convocatoria</h5>
                                    </div>
                                    <div class="p-2 text-center bg-success bg-darken-2 rounded-right">
                                        <i class="icon-plus font-large-2 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Convocatorias Pendientes de Aprobación</h4>
                            <a class="heading-elements-toggle"><i class="ft-more-horizontal font-medium-3"></i></a>
                            <div class="heading-elements">
                                <a href="{{action('AdminConvocatorias@Index')}}">Ver todas <i class="ft-arrow-right"></i></a></span></p>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Convocatoria</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dashboard->convocatorias as $item)
                                        <tr>
                                            <td class="text-truncate">{{$item->nombre}}</td>
                                            <td class="text-truncate">
                                                <span>{{$item->responsable->nombre}}</span>
                                            </td>
                                            <td class="text-truncate">
                                                @switch($item->activo)
                                                    @case('No')
                                                    <span class="badge badge-dark round">Draft</span>
                                                    @break
                                                    @case('Si')
                                                    <span class="badge badge-success round">Activa</span>
                                                    @break
                                                    @case('aprobacion')
                                                    <span class="badge badge-warning round">Para Aprobación</span>
                                                    @break
                                                    @case('cerrada')
                                                    <span class="badge badge-danger round">Cerrada</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ action('AdminConvocatorias@Edit',$item->_key) }}" class="btn btn-secondary btn-sm"><i class="icon-grid"></i> Ver</a>
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

            <!--CLNDR Wrapper-->
            <div id="clndr" class="clearfix">
                <script type="text/template" id="clndr-template">
                    <div class="clndr-controls">
                        <div class="clndr-previous-button">&lt;</div>
                        <div class="clndr-next-button">&gt;</div>
                        <div class="current-month">
    <%= month %>
        <%= year %>
</div>
</div>
<div class="clndr-grid">
<div class="days-of-the-week clearfix">
    <% _.each(daysOfTheWeek, function(day) { %>
        <div class="header-day">
            <%= day %>
        </div>
        <% }); %>
</div>
<div class="days">
    <% _.each(days, function(day) { %>
        <div class="<%= day.classes %>" id="<%= day.id %>"><span class="day-number"><%= day.day %></span></div>
        <% }); %>
</div>
</div>
<div class="event-listing">
<div class="event-listing-title">Project meetings</div>
<% _.each(eventsThisMonth, function(event) { %>
    <div class="event-item font-small-3">
        <div class="event-item-day font-small-2">
            <%= event.date %>
        </div>
        <div class="event-item-name text-bold-600">
            <%= event.title %>
        </div>
        <div class="event-item-location">
            <%= event.location %>
        </div>
    </div>
    <% }); %>
</div>
</script>
</div>
<!--/CLNDR Wrapper -->

</div>
</div>
@endsection
