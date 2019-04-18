<div id="datos_catalogo" class="listados hidden">
    @foreach($preguntas_catalogo as $categoria=>$items)
        <div class="item titulo">
            <div class="row">
                <div class="col-10">{{$categoria}}</div>
            </div>
        </div>
        @foreach($items as $item)
            <div class="item" id="catalogo_{{$item->_key}}">
                <div class="row">
                    <div class="col-10">
                        <span class="custom-checkbox">{{$item->pregunta}}</span>
                        <fieldset class="form-group form-group-style hidden m-0">
                            <label for="input_{{$item->_key}}">Nombre</label>
                            <input type="text" class="form-control" value="{{$item->pregunta}}" data-dato="catalogos" data-name="nombre" id="input_{{$item->_key}}"/>
                        </fieldset>
                        <fieldset class="form-group form-group-style hidden m-0">
                            <label for="input_{{$item->_key}}">Descripción del campo</label>
                            <input type="text" class="form-control m-0" value="" data-dato="catalogos" data-name="desc" style="margin-top: 10px;" placeholder="" id="input_{{$item->_key}}"/>
                        </fieldset>
                        <input type="hidden" value="{{$item->_key}}" data-dato="catalogos" data-name="campo"/>
                    </div>
                    <div class="col-2 text-right">
                        <div class="d-inline-block custom-control custom-checkbox mr-1">
                            <input type="checkbox" class="custom-control-input bg-success" id="check_{{$item->_key}}" value="catalogo_{{$item->_key}}">
                            <label class="custom-control-label" for="check_{{$item->_key}}"></label>
                        </div>
                        <button class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></button>
                        <button class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>