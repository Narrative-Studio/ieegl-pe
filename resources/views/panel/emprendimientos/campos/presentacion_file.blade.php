<p>
@if($value!='')
    @if(file_exists(public_path($value)))
        <?php $archivo = explode('.',$value)?>
        @if($archivo[1]=='pdf')
            <a class="btn btn-sm btn-primary" href="{{url($value)}}" target="_blank"><i class="fa fa-search-plus"></i> Ver </a>
        @else
            <img src="{{url($value)}}?{{str_random(15)}}" width="100" height="100" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
        @endif
    @endif
@else
    <span class="small">Tu emprendimiento no tiene este documento, puedes actualizarlo directamente en tu <a href="{{action('PanelEmprendimientos@MediosDigitales', $emprendimiento->_key)}}" target="_blank">emprendimiento</a>.</span>
@endif
{!! Form::hidden($campo, $value, ["class"=>$class]) !!}
</p>