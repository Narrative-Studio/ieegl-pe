<div class="row">
    <div class="col-md-1">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "Si", $value, ['id'=>'socio1', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="socio1">Si</label>
        </div>
    </div>
    <div class="col-md-1">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "No", $value, ['id'=>'socio2', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="socio2">No</label>
        </div>
    </div>
</div>