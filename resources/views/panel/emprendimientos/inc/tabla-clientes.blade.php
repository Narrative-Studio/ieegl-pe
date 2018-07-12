@if($i==1) </div>  <div class="@if(count($meses)>1) col-md-6 @else col-md-12 @endif"> @endif
<h3>Año {{$year}}</h3>
<hr />
@foreach($months as $month)
    <div class="row">
        <div class="@if(count($meses)>1) col-md-4 @else col-md-2 @endif">
            <?php $nombre_input="mes_".(int)$month."_".$year;?>
            <div class="form-group">
                <label for="">Clientes en <span class="nombre_mes">{{$n_meses[(int)$month]}}</span> {{$year}} <span class="required">*</span></label>
                <div class="input-group">
                    {!! Form::number($nombre_input, (isset($montos[$year][$month]))?$montos[$year][$month]:null, ['class'=>'form-control', 'required' =>'required']); !!}
                </div>
            </div>
        </div>
    </div>
@endforeach