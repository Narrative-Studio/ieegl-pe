<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Sitio Web de tu Emprendimiento<small>Ej. www.misitio.com</small></label>
                <?php $class=($errors->has('sitio_web'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('sitio_web', null, ['class'=>$class, 'aria-describedby'=>'sitio_des']) !!}
                @if ($errors->has('sitio_web'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('sitio_web') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="">Logo de tu Emprendimiento en alta definición <small>(opcional)</small></label>
                <div class="row">
                    <div class="col-md-4">
                        @if(isset($item->_key))
                            @if(file_exists(public_path('/emprendimientos_pics/logo_'.$item->_key.'.jpg')))
                                <img src="{{url('/emprendimientos_pics/logo_'.$item->_key.'.jpg')}}?{{str_random(15)}}" width="120" height="120" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
                            @else
                                <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                            @endif
                        @endif
                    </div>
                    <div class="col-md-8">
                        <input type='file' name="logo" id="" accept=".jpg, .jpeg" />
                        @if ($errors->has('logo'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('logo') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Red social mas utilizada por tu Emprendimiento<small>Incluye el nombre de usuario o nickname (Ej. www.facebook.com/usuario)</small></label>
                <?php $class=($errors->has('red_social'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('red_social', null, ['class'=>$class, 'aria-describedby'=>'sitio_red']) !!}
                @if ($errors->has('red_social'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('red_social') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Video de tu Emprendimiento<small>Sube un video a youtube con tu pitch y copia el URL aquí.</small></label>
                <?php $class=($errors->has('video'))?'form-control is-invalid':'form-control'; ?>
                {!! Form::text('video', null, ['class'=>$class, 'aria-describedby'=>'sitio_video']) !!}
                @if ($errors->has('video'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('video') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="">Agrega tu presentación o pitch deck (PDF) <small>(opcional)</small></label>
                <div class="row">
                    <div class="col-md-4">
                        @if(isset($item->_key))
                            @if(file_exists(public_path('/emprendimientos_pdf/presentacion_'.$item->_key.'.pdf')))
                                <a href="{{url('/emprendimientos_pdf/presentacion_'.$item->_key.'.pdf')}}" target="_blank">Presentacion</a>
                            @else
                                <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-pdf-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                            @endif
                        @endif
                    </div>
                    <div class="col-md-8">
                        <input type='file' name="presentacion" id="" accept=".pdf" />
                        @if ($errors->has('presentacion'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('presentacion') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>