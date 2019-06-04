<div class="row">
    @foreach($industrias as $item)
        <div class="radio_input col-md-{{$columns}}">
            <fieldset>
                <label> <input name="{{$campo}}" <?php if(in_array($item->_key, $value)) echo 'checked="checked"' ?> type="checkbox" value="{{$item->_key}}"> {{$item->nombre}}</label>
            </fieldset>
        </div>
    @endforeach
</div>