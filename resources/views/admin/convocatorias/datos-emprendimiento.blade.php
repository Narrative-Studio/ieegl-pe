<div id="datos_emprendimiento" class="listados hidden">
    @foreach($campos_emprendimiento as $categoria=>$items)
        <div class="item titulo">
            <div class="row">
                <div class="col-10">{{$categoria}}</div>
            </div>
        </div>
        @foreach($items as $campo=>$titulo)
            <div class="item" id="emprendimiento_{{$campo}}">
                <div class="row">
                    <div class="col-10 pr-0">
                        <span class="custom-checkbox">{{$titulo}}</span>
                        <fieldset class="form-group form-group-style hidden m-0">
                            <input type="text" class="form-control" value="{{$titulo}}" data-dato="emprendimiento" data-name="nombre" id="input_{{$campo}}"/>
                            <input type="text" class="form-control m-0 campo_descripcion" value="" data-dato="emprendimiento" data-name="desc" style="margin-top: 10px;" placeholder="Descripción del campo" id="input_{{$campo}}"/>
                        </fieldset>
                        <input type="hidden" value="{{$campo}}"data-dato="emprendimiento" data-name="campo" />
                        <input type="hidden" value="emprendimiento" data-dato="emprendimiento" data-name="tipo" />
                    </div>
                    <div class="col-2 text-right pl-0">
                        <div class="d-inline-block custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input bg-success" id="check_{{$campo}}" value="emprendimiento_{{$campo}}">
                            <label class="custom-control-label" for="check_{{$campo}}"></label>
                        </div>
                        <div class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></div>
                        <div class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>