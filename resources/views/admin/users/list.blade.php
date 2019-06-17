@extends('layouts.admin')

@section('titulo') Listado de Usuarios @endsection
@section('seccion') Usuarios @endsection
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
                                {!! Form::open(['action'=>'AdminUsuarios@Index', 'method'=>'GET', 'class'=>'navbar-form navbar-left', 'role'=>'search']) !!}
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Texto a buscar" name="q" value="{{Request::input('q')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        <h4>Total: {{$total}} registros</h4>
                                    </div>
                                </div>
                                </form>
                            </div>
                            @if(count($datos)>0)
                                <div class="table-responsive table-hover">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr class="bg-primary white">
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Validado</th>
                                            <th width="200">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datos as $item)
                                            <tr>
                                                <td>{{$item->_key}}</td>
                                                <td>{{$item->nombre}} @if(isset($item->apellidos)){{$item->apellidos}}@endif</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->telefono}}</td>
                                                <td>@if($item->validated==0) <div class="badge badge-warning">No</div> @else <div class="badge badge-success">Si</div> @endif</td>
                                                <td>
                                                    <a href="{{ action('AdminUsuarios@Edit',$item->_key) }}" class="btn btn-sm btn-info mr-1"><i class="fas fa-edit"></i> Editar</a>
                                                    <a href="#" onclick="delete_row('item-{{$item->_key}}', '{{ action('AdminUsuarios@Delete',$item->_key) }}')" class="btn btn-sm  btn-danger mr-1"><i class="fas fa-trash"></i></a>
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


