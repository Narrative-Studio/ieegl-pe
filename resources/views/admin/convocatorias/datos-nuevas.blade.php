<div id="datos_nueva" class="listados hidden">
    <div class="item" id="campo_nuevo">
        <div class="row">
            <div class="col-10">
                <fieldset class="form-group form-group-style m-0">
                    <label for="input_nueva_nombre">Nombre</label>
                    <input type="text" class="form-control" data-dato="nueva" data-name="nombre" id="input_nueva_nombre"/>
                </fieldset>
                <fieldset class="form-group form-group-style m-0">
                    <label for="input_nueva_desc">Descripción del campo</label>
                    <input type="text" class="form-control m-0" data-dato="nueva" data-name="placeholder" style="margin-top: 10px;" id="input_nueva_desc"/>
                </fieldset>
                <fieldset class="form-group form-group-style m-0">
                    <label for="input_nueva_tipo_pregunta">Tipo</label>
                    {!! Form::select('tipo_pregunta', ['text'=>'Texto','combo'=>'Combo','multiple'=>'Multiple','textarea'=>'Textarea'], null, ['class'=> 'form-control m-0', 'id'=>'input_nueva_tipo', 'data-dato'=>'nueva', 'data-name'=>'tipo_pregunta', 'onchange'=>'cambioTipoPregunta(this)']) !!}
                </fieldset>
                <fieldset class="form-group form-group-style m-0 nueva_respuestas_select hidden">
                    <label for="input_nueva_respuestas">Respuestas <small>Respuesta por renglón</small></label>
                    <textarea class="form-control m-0" rows="4" data-dato="nueva" data-name="respuestas" style="margin-top: 10px;" id="input_nueva_respuestas"></textarea>
                </fieldset>
                <input type="hidden" value="nueva" data-dato="nueva" data-name="tipo" />
                <div class="form-actions right">
                    <button type="button" class="btn btn-success" id="guardar_pregunta">
                        <i class="fa fa-save"></i> Guardar Pregunta
                    </button>
                </div>
            </div>
            <div class="col-2 text-right">
                <button class="btn btn-light btn-sm hidden" onclick="deleteItem(this)"><span class="fa fa-times-circle"></span></button>
                <button class="btn btn-light btn-sm handle hidden"><span class="fa fa-reorder" aria-hidden="true"></span></button>
            </div>
        </div>
    </div>
</div>