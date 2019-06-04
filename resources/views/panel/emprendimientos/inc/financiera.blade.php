<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">¿Ya lanzaste tu producto/servicio al mercado? <span class="required">*</span></label>
                <?php $class=($errors->has('lanzar_producto'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.lanzar_producto', ['campo'=>'lanzar_producto','value'=>($item)?$item->lanzar_producto:''])
                @if ($errors->has('lanzar_producto'))
                    <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('lanzar_producto') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Si ya lanzaste tu producto, ¿En qué fecha fue? <span class="required">*</span></label>
                <?php $class=($errors->has('fecha_lanzamiento'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.fecha_lanzamiento', ['campo'=>'fecha_lanzamiento','value'=>($item)?$item->fecha_lanzamiento:''])
                @if ($errors->has('fecha_lanzamiento'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('fecha_lanzamiento') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Tienes una Patente o IP de tu producto o servicio? <span class="required">*</span></label>
                    <?php $class=($errors->has('patente_ip'))?'form-control is-invalid':'form-control'; ?>
                    @include('panel.emprendimientos.campos.patente_ip', ['campo'=>'patente_ip','value'=>($item)?$item->patente_ip:''])
                    @if ($errors->has('patente_ip'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('patente_ip') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Has tenido ventas? <span class="required">*</span></label>
                    <?php $class=($errors->has('realizado_ventas'))?'form-control is-invalid':'form-control'; ?>
                    @include('panel.emprendimientos.campos.realizado_ventas', ['campo'=>'realizado_ventas','value'=>($item)?$item->realizado_ventas:''])
                    @if ($errors->has('realizado_ventas'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('realizado_ventas') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <label for="" class="">Si ya has tenido ventas, ¿cuánto ha sido en los últimos 3 meses? (USD)</label>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes 1</label>
                    <?php $class=($errors->has('mes1'))?'form-control is-invalid':'form-control'; ?>
                    @include('panel.emprendimientos.campos.mes1', ['campo'=>'mes1','value'=>(isset($item->mes1))?$item->mes1:''])
                    @if ($errors->has('mes1'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mes1') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes 2</label>
                    <?php $class=($errors->has('mes2'))?'form-control is-invalid':'form-control'; ?>
                    @include('panel.emprendimientos.campos.mes2', ['campo'=>'mes2','value'=>(isset($item->mes1))?$item->mes2:''])
                    @if ($errors->has('mes2'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mes2') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes 3</label>
                    <?php $class=($errors->has('mes3'))?'form-control is-invalid':'form-control'; ?>
                    @include('panel.emprendimientos.campos.mes3', ['campo'=>'mes3','value'=>(isset($item->mes1))?$item->mes3:''])
                    @if ($errors->has('mes3'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('mes3') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">¿Alguno de tus socios ha tenido un "exit" o ha venido de una empresa? <span class="required">*</span></label>
                    <?php $class=($errors->has('socio_exit_empresa'))?'form-control is-invalid':'form-control'; ?>
                    @include('panel.emprendimientos.campos.socio_exit_empresa', ['campo'=>'socio_exit_empresa','value'=>($item)?$item->socio_exit_empresa:''])
                    @if ($errors->has('socio_exit_empresa'))
                        <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('socio_exit_empresa') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>