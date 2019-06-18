<div class="row">
    @foreach($industrias as $item)
        <div class="radio_input col-md-{{$columns}}">
            <fieldset>
                <label> <input class="required" name="{{$campo}}" <?php if(is_array($value)) if(in_array($item->_key, $value)) echo 'checked="checked"' ?> type="checkbox" value="{{$item->_key}}"> {{$item->nombre}}</label>
            </fieldset>
        </div>
    @endforeach
</div>