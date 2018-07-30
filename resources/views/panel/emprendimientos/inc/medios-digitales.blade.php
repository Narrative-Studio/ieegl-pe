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
</div>