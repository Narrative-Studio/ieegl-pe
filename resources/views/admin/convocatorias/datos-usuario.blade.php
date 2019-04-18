<div id="datos_usuario" class="listados">
    @foreach($campos_usuario as $categoria=>$items)
        <div class="item titulo">
            <div class="row">
                <div class="col-10">{{$categoria}}</div>
            </div>
        </div>
        @foreach($items as $campo=>$titulo)
            <div class="item" id="usuario_{{$campo}}">
                <div class="row">
                    <div class="col-10">
                        <span class="custom-checkbox">{{$titulo}}</span>

                        <fieldset class="form-group form-group-style hidden m-0">
                            <label for="input_{{$campo}}">Nombre</label>
                            <input type="text" class="form-control" value="{{$titulo}}" data-dato="usuarios" data-name="nombre" id="input_{{$campo}}"/>
                        </fieldset>
                        <fieldset class="form-group form-group-style hidden m-0">
                            <label for="input_{{$campo}}">Descripción del campo</label>
                            <input type="text" class="form-control m-0" value="" data-dato="usuarios" data-name="desc" style="margin-top: 10px;" placeholder="" id="input_{{$campo}}"/>
                        </fieldset>
                        <input type="hidden" value="{{$campo}}"data-dato="usuarios" data-name="campo" />
                    </div>
                    <div class="col-2 text-right">
                        <div class="d-inline-block custom-control custom-checkbox mr-1">
                            <input type="checkbox" class="custom-control-input bg-success" id="check_{{$campo}}" value="usuario_{{$campo}}">
                            <label class="custom-control-label" for="check_{{$campo}}"></label>
                        </div>
                        <button class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></button>
                        <button class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>