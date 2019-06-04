<div class="row">
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "Si", $value, ['id'=>'v1', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="v1">Si</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "No", $value, ['id'=>'v2', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="v2">No</label>
        </div>
    </div>
</div>