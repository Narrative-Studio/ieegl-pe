<div class="row">
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            <?php $uuid = "radio_".uniqid();?>
            <input type="radio" name="{{$campo}}" id="{{$uuid}}" value="Si" class="custom-control-input required" @if($value=="Si") checked="checked" @endif/>
            <label class="custom-control-label"  for="{{$uuid}}">Si</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="d-inline-block custom-control custom-radio mr-1">
            <?php $uuid = "radio_".uniqid();?>
            <input type="radio" name="{{$campo}}" id="{{$uuid}}" value="No" class="custom-control-input required" @if($value=="No") checked="checked" @endif/>
            <label class="custom-control-label"  for="{{$uuid}}">No</label>
        </div>
    </div>
</div>