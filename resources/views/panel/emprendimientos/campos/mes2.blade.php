<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">$</span>
    </div>
    {!! Form::text($campo, $value, ['class'=>'money2 '.$class]); !!}
    <div class="input-group-append">
        <span class="input-group-text">USD</span>
    </div>
</div>