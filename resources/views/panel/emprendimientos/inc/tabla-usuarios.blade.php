@if($i==1) </div>  <div class="@if(count($meses_usuarios)>1) col-md-6 @else col-md-12 @endif"> @endif
<h3>Año {{$year}}</h3>
<hr />
@foreach($months as $month)
    <div class="row">
        <div class="@if(count($meses_usuarios)>1) col-md-5 @else col-md-3 @endif">
            <?php $nombre_input="mes_".(int)$month."_".$year;?>
            <div class="form-group">
                <label for="">Usuarios activos en <span class="nombre_mes">{{$n_meses_usuarios[(int)$month]}}</span> {{$year}} <span class="required">*</span></label>
                <div class="input-group">
                    {!! Form::number($nombre_input, (isset($montos_usuarios[$year][$month]))?$montos_usuarios[$year][$month]:null, ['class'=>'form-control', 'required' =>'required', 'min'=>0]); !!}
                </div>
            </div>
        </div>
    </div>
@endforeach