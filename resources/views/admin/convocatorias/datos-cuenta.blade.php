<div id="datos_cuenta" class="listados hidden">
    @foreach($campos_cuenta as $categoria=>$items)
        <div class="item titulo">
            <div class="row">
                <div class="col-10">{{$categoria}}</div>
            </div>
        </div>
        @foreach($items as $campo=>$titulo)
            <div class="item" id="cuenta_{{$campo}}">
                <div class="row">
                    <div class="col-10 pr-0">
                        <span class="custom-checkbox">{{$titulo}}</span>
                        <fieldset class="form-group form-group-style hidden m-0">
                            <input type="text" class="form-control" value="{{$titulo}}" data-dato="cuenta" data-name="nombre" id="input_cuenta_{{$campo}}"/>
                            <input type="text" class="form-control m-0 campo_descripcion" value="" data-dato="cuenta" data-name="desc" style="margin-top: 10px;" placeholder="Descripción del campo" id="input_cuenta_{{$campo}}"/>
                        </fieldset>
                        <input type="hidden" value="{{$campo}}" data-dato="cuenta" data-name="campo" />
                        <input type="hidden" value="cuenta" data-dato="cuenta" data-name="tipo" />
                    </div>
                    <div class="col-2 text-right pl-0">
                        <div class="d-inline-block custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input bg-success" id="check_cuenta_{{$campo}}" value="cuenta_{{$campo}}">
                            <label class="custom-control-label" for="check_cuenta_{{$campo}}"></label>
                        </div>
                        <div class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></div>
                        <div class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>