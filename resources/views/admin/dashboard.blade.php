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
                                            <h3 class="font-large-1 grey darken-1 text-bold-400">84,000</h3>
                                            <span class="font-small-3 grey darken-1">Usuarios</span>
                                        </div>
                                        <div class="card-content overflow-hidden">
                                            <div id="morris-comments" class="height-75"></div>
                                            <ul class="list-inline clearfix mb-0">
                                                <li class="border-right-grey border-right-lighten-2 pr-2">
                                                    <h3 class="success text-bold-400">3,200</h3>
                                                    <span class="font-small-3 grey darken-1">Hoy</span>
                                                </li>
                                                <li class="pl-2">
                                                    <h3 class="success text-bold-400">5,400</h3>
                                                    <span class="font-small-3 grey darken-1">Último Mes</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                    <div class="p-1 text-center">
                                        <div>
                                            <h3 class="font-large-1 grey darken-1 text-bold-400">1,879</h3>
                                            <span class="font-small-3 grey darken-1">Emprendimientos</span>
                                        </div>
                                        <div class="card-content overflow-hidden">
                                            <div id="morris-likes" class="height-75"></div>
                                            <ul class="list-inline clearfix mb-0">
                                                <li class="border-right-grey border-right-lighten-2 pr-2">
                                                    <h3 class="primary text-bold-400">4789</h3>
                                                    <span class="font-small-3 grey darken-1">Hoy</span>
                                                </li>
                                                <li class="pl-2">
                                                    <h3 class="primary text-bold-400">389</h3>
                                                    <span class="font-small-3 grey darken-1">Último Mes</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="p-1 text-center">
                                        <div>
                                            <h3 class="font-large-1 grey darken-1 text-bold-400">894</h3>
                                            <span class="font-small-3 grey darken-1">Convocatorias</span>
                                        </div>
                                        <div class="card-content overflow-hidden">
                                            <div id="morris-views" class="height-75"></div>
                                            <ul class="list-inline clearfix mb-0">
                                                <li class="border-right-grey border-right-lighten-2 pr-2">
                                                    <h3 class="danger text-bold-400">81</h3>
                                                    <span class="font-small-3 grey darken-1"> Hoy</span>
                                                </li>
                                                <li class="pl-2">
                                                    <h3 class="danger text-bold-400">498</h3>
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
                            <div class="media align-items-stretch">
                                <div class="p-2 bg-success text-white media-body text-left rounded-left">
                                    <h5 class="text-white text-bold-400 mt-1">Crear Convocatoria</h5>
                                </div>
                                <div class="p-2 text-center bg-success bg-darken-2 rounded-right">
                                    <i class="icon-plus font-large-2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <div class="card-header mb-2">
                                    <span class="success darken-1">Total de Aplicaciones</span>
                                    <h3 class="font-large-2 grey darken-1 text-bold-200">24,879</h3>
                                </div>
                                <div class="card-content">
                                    <input type="text" value="75" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="150" data-height="150" data-inputColor="#e1e1e1" data-readOnly="true" data-fgColor="#37BC9B" data-knob-icon="ft-trending-up">
                                    <ul class="list-inline clearfix mt-2 mb-0">
                                        <li class="border-right-grey border-right-lighten-2 pr-2">
                                            <h2 class="grey darken-1 text-bold-400">75%</h2>
                                            <span class="success">Aceptadas</span>
                                        </li>
                                        <li class="pl-2">
                                            <h2 class="grey darken-1 text-bold-400">25%</h2>
                                            <span class="danger">Rechazadas</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Convocatorias Abiertas</h4>
                            <a class="heading-elements-toggle"><i class="ft-more-horizontal font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <p class="m-0">Total de convocatorias abiertas 6<span class="float-right"><a href="project-summary.html" target="_blank">Ver todas <i class="ft-arrow-right"></i></a></span></p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Convocatoria</th>
                                        <th>Responsable</th>
                                        <th>Ver Aplicaciones</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-truncate">ReactJS App</td>
                                        <td class="text-truncate">
                                            <span class="avatar avatar-xs"><img src="{{url("/")}}/app-assets/images/portrait/small/avatar-s-4.png" alt="avatar"></span> <span>Sarah W.</span>
                                        </td>
                                        <td class="text-truncate"><span class="tag tag-success">Low</span></td>

                                    </tr>
                                    <tr>
                                        <td class="text-truncate">Fitness App</td>
                                        <td class="text-truncate">
                                            <span class="avatar avatar-xs"><img src="{{url("/")}}/app-assets/images/portrait/small/avatar-s-5.png" alt="avatar"></span> <span>Edward C.</span>
                                        </td>
                                        <td class="text-truncate"><span class="tag tag-warning">Medium</span></td>

                                    </tr>
                                    <tr>
                                        <td class="text-truncate">SOU plugin</td>
                                        <td class="text-truncate">
                                            <span class="avatar avatar-xs"><img src="{{url("/")}}/app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"></span> <span>Carol E.</span>
                                        </td>
                                        <td class="text-truncate"><span class="tag tag-danger">Critical</span></td>

                                    </tr>
                                    <tr>
                                        <td class="text-truncate">Android App</td>
                                        <td class="text-truncate">
                                            <span class="avatar avatar-xs"><img src="{{url("/")}}/app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"></span> <span>Gregory L.</span>
                                        </td>
                                        <td class="text-truncate"><span class="tag tag-success">Low</span></td>

                                    </tr>
                                    <tr>
                                        <td class="text-truncate">ABC Inc. UI/UX</td>
                                        <td class="text-truncate">
                                            <span class="avatar avatar-xs"><img src="{{url("/")}}/app-assets/images/portrait/small/avatar-s-8.png" alt="avatar"></span> <span>Susan S.</span>
                                        </td>
                                        <td class="text-truncate"><span class="tag tag-warning">Medium</span></td>

                                    </tr>

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
