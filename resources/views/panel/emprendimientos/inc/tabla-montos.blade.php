@if($i==1) </div>  <div class="@if(count($meses)>1) col-md-6 @else col-md-12 @endif"> @endif
<h3>Año {{$year}}</h3>
<hr />
@foreach($months as $month)
    <div class="row">
        <div class="@if(count($meses)>1) col-md-8 @else col-md-4 @endif">
            <?php $nombre_input="mes_".(int)$month."_".$year;?>
            <div class="form-group">
                <label for="" class="nombre_mes">{{$n_meses[(int)$month]}} {{$year}} <span class="required">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    {!! Form::text($nombre_input, (isset($montos[$year][$month]))?$montos[$year][$month]:0, ['class'=>'money form-control', 'required' =>'required']); !!}
                    <div class="input-group-append">
                        <span class="input-group-text">USD</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach