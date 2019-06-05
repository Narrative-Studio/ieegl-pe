<div id="datos_catalogo" class="listados hidden">
    @foreach($preguntas_catalogo as $categoria=>$items)
        <div class="item titulo">
            <div class="row">
                <div class="col-10">{{$categoria}}</div>
            </div>
        </div>
        @foreach($items as $item)
            <div class="item" id="catalogos_{{$item->_key}}">
                <div class="row">
                    <div class="col-10 pr-0">
                        <span class="custom-checkbox">{{$item->pregunta}}</span>
                        <fieldset class="form-group form-group-style hidden m-0">
                            <input type="text" class="form-control" value="{{$item->pregunta}}" placeholder="Nombre" data-dato="catalogos" data-name="nombre" id="input_catalogos_{{$item->_key}}"/>
                            <input type="text" class="form-control m-0 campo_descripcion" value="" data-dato="catalogos" data-name="desc" style="margin-top: 10px;" placeholder="Descripción del campo" id="input_catalogos_{{$item->_key}}"/>
                        </fieldset>
                        <input type="hidden" value="{{$item->_key}}" data-dato="catalogos" data-name="campo"/>
                        <input type="hidden" value="catalogos" data-dato="catalogos" data-name="tipo" />
                    </div>
                    <div class="col-2 text-right pl-0">
                        <div class="d-inline-block custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input bg-success" id="checks_catalogos_{{$item->_key}}" value="catalogos_{{$item->_key}}">
                            <label class="custom-control-label" for="checks_catalogos_{{$item->_key}}"></label>
                        </div>
                        <div class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></div>
                        <div class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>