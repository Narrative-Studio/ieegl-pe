@extends('layouts.admin')

@section('titulo') Listado de Industrias @endsection
@section('seccion') Industrias @endsection
@section('accion') Listado @endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.breadcrum')
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <a href="{{ action('AdminIndustrias@New') }}" class="btn btn-success mr-1 pull-right"><i class="fas fa-edit"></i> Crear Nuevo</a>
                                    </div>
                                </div>
                                <!--{!! Form::open(['action'=>'AdminIndustrias@Index', 'method'=>'GET', 'class'=>'navbar-form navbar-left', 'role'=>'search']) !!}
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Texto a buscar" name="q" value="{{Request::input('q')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                                    </div>
                                </div>
                                </form>-->
                            </div>
                            @if(count($datos)>0)
                                <div class="table-responsive table-hover">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr class="bg-primary white">
                                            <th>Nombre</th>
                                            <th width="250">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datos as $item)
                                            <tr>
                                                <td>{{$item->nombre}}</td>
                                                <td>
                                                    <a href="{{ action('AdminIndustrias@Edit',$item->_key) }}" class="btn btn-sm btn-info mr-1"><i class="fas fa-edit"></i> Editar</a>
                                                    <a href="#" onclick="delete_row('item-{{$item->_key}}', '{{ action('AdminIndustrias@Delete',$item->_key) }}')" class="btn btn-sm  btn-danger mr-1"><i class="fas fa-trash"></i> Borrar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12"><div class="dataTables_paginate paging_full_numbers">
                                        {!! $datos->appends(['total' => (int)$total]+\Illuminate\Support\Facades\Input::except('page'))->render() !!}
                                </div></div>

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
@endsection


