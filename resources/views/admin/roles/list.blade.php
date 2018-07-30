@extends('layouts.admin')

@section('titulo') Roles @endsection
@section('seccion') Roles @endsection
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
                                        <a href="{{ action('AdminRoles@New') }}" class="btn btn-success mr-1 pull-right"><i class="fas fa-edit"></i> Crear Nuevo</a>
                                    </div>
                                </div>
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
                                                    <a href="{{ action('AdminRoles@Edit',$item->_key) }}" class="btn btn-sm btn-info mr-1"><i class="fas fa-edit"></i> Editar</a>
                                                    <!--<a href="#" onclick="delete_row('item-{{$item->_key}}', '{{ action('AdminRoles@Edit',$item->_key) }}')" class="btn btn-sm  btn-danger mr-1"><i class="fas fa-trash"></i> Borrar</a>-->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12">
                                    <div class="dataTables_paginate paging_full_numbers">
                                        {!! $datos->appends(['total' => (int)$total]+\Illuminate\Support\Facades\Input::except('page'))->render() !!}
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
@endsection


