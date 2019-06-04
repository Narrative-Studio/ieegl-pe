<div class="row">
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "Si", $value, ['id'=>'cl1', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="cl1">Si</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            {!! Form::radio($campo, "No", $value, ['id'=>'cl2', 'class'=>'custom-control-input required']); !!}
            <label class="custom-control-label" for="cl2">No</label>
        </div>
    </div>
</div>