@extends('layouts.admin')

@section('titulo') Listado de Convocatorias @endsection
@section('seccion') Convocatorias @endsection
@section('accion') Listado de Convocatorias @endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#status').on('change', function(){
                $('#search').submit();
            });
        });
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body"><!-- project stats -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">CONVOCATORIAS</h4>
                                <div class="card-content">
                                    <div class="card-body">
                                        {!! Form::open(['action' => ['AdminConvocatorias@Index'], 'method'=>'GET', 'id'=>'search', 'class'=>'form']) !!}
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                {!! Form::select('status', [''=>'Todos los Estatus', 'Si'=>'Abierta','No'=>'Draft','aprobacion'=>'Para Aprobacion', 'cerrada'=>'Cerrada'], \Illuminate\Support\Facades\Input::get('status'), ['id'=>'status','class'=> 'select2']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        @if(count($datos)>0)
                                            <div class="table-responsive">
                                                <table id="project-bugs-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                                    <thead>
                                                    <tr>
                                                        <th>Convocatoria</th>
                                                        <th>Fecha Cierre</th>
                                                        <th># Aplicaciones</th>
                                                        <th>Estatus</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($datos as $item)
                                                        <tr>
                                                            <td class="text-left" style="white-space:normal ;">
                                                                {{$item->nombre}}
                                                            </td>
                                                            <td class="text-center">
                                                                <p class="text-bold-600 font-small-3">{{\Illuminate\Support\Carbon::createFromTimestamp($item->fecha_fin_convocatoria)->formatLocalized('%d %B %Y')}}</p>
                                                            </td>
                                                            <td class="text-center">
                                                                {{$item->total}}
                                                            </td>
                                                            <td>
                                                                @switch($item->activo)
                                                                    @case('No')
                                                                    <span class="badge badge-dark round">Draft</span>
                                                                    @break
                                                                    @case('Si')
                                                                    <span class="badge badge-success round">Abierta</span>
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
                                                                <a href="{{ action('AdminReportes@Aplicaciones',$item->_key) }}" class="btn btn-secondary btn-sm"><i class="fa fa-line-chart"></i> Aplicaciones</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="col-sm-12">
                                                    <div class="dataTables_paginate paging_full_numbers">
                                                        {!! $datos->appends(['total' => (int)$total]+\Illuminate\Support\Facades\Input::except('page'))->render() !!}
                                                    </div>
                                                </div>

                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <div class="alert round bg-warning alert-icon-right alert-dismissible mb-2 text-center" role="alert">
                                                        <span class="alert-icon"><i class="fa fa-info-circle"></i></span>
                                                        No hay datos
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


