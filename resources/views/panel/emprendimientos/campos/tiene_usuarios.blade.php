<div class="row">
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "Si", $value, ['id'=>'us1', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="us1">Si</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "No", $value, ['id'=>'us2', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="us2">No</label>
        </div>
    </div>
</div>