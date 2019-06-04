<div id="datos_nueva" class="listados hidden">
    <div class="item" id="campo_nuevo">
        <div class="row">
            <div class="col-10 pr-0">
                <fieldset class="form-group form-group-style m-0">
                    <input type="text" class="form-control" placeholder="Nombre" data-dato="nueva" data-name="nombre" id="input_nueva_nombre"/>
                    <input type="text" class="form-control campo_descripcion m-0" placeholder="Descripción del campo" data-dato="nueva" data-name="placeholder" style="margin-top: 10px;" id="input_nueva_desc"/>
                    {!! Form::select('tipo_pregunta', ['text'=>'Texto','combo'=>'Combo','multiple'=>'Multiple','textarea'=>'Textarea'], null, ['class'=> 'form-control m-0', 'id'=>'input_nueva_tipo', 'data-dato'=>'nueva', 'data-name'=>'tipo_pregunta', 'onchange'=>'cambioTipoPregunta(this)']) !!}
                    <div class="form-group form-group-style m-0 nueva_respuestas_select hidden">
                        <textarea class="form-control m-0" rows="4" data-dato="nueva" data-name="respuestas" style="margin-top: 10px;" id="input_nueva_respuestas" placeholder="Una respuesta por renglón"></textarea>
                    </div>
                    <input type="hidden" value="nueva" data-dato="nueva" data-name="tipo" />
                    <input type="hidden" value="" data-dato="nueva" data-name="campo" class="uuid" />
                    <div class="form-actions right">
                        <button type="button" class="btn btn-success" id="guardar_pregunta">
                            <i class="fa fa-save"></i> Guardar Pregunta
                        </button>
                    </div>
                </fieldset>
            </div>
            <div class="col-2 text-right pl-0">
                <div class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></div>
                <div class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></div>
            </div>
        </div>
    </div>
</div>