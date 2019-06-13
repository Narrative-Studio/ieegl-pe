<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Sitio Web de tu Emprendimiento <span class="required">*</span> <small>Ej. www.misitio.com</small></label>
                <?php $class=($errors->has('sitio_web'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.sitio_web', ['campo'=>'sitio_web','value'=>($item)?$item->sitio_web:''])
                @if ($errors->has('sitio_web'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('sitio_web') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Red social mas utilizada por tu Emprendimiento <span class="required">*</span> <small>Incluye el nombre de usuario o nickname (Ej. www.facebook.com/usuario)</small></label>
                <?php $class=($errors->has('red_social'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.red_social', ['campo'=>'red_social','value'=>($item)?$item->red_social:''])
                @if ($errors->has('red_social'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('red_social') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Video de tu Emprendimiento <span class="required">*</span> <small>Sube un video a youtube con tu pitch y copia el URL aquí.</small></label>
                <?php $class=($errors->has('video'))?'form-control is-invalid':'form-control'; ?>
                @include('panel.emprendimientos.campos.video', ['campo'=>'video','value'=>($item)?$item->video:''])
                @if ($errors->has('video'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('video') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label for="">Logo de tu Emprendimiento en alta definición </label>
                <div class="row">
                    <div class="col-md-4">
                        @if(isset($item->logo_file))
                            @if(file_exists(public_path($item->logo_file)))
                                <img src="{{url($item->logo_file)}}?{{str_random(15)}}" width="120" height="120" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
                                <input type="hidden" name="logo_file" value="{{$item->logo_file}}" />
                            @endif
                        @else
                            <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-photo-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                        @endif
                    </div>
                    <div class="col-md-8">
                        <input type='file' name="logo" id="" accept=".jpg, .jpeg, .gif, .png" />
                        @if ($errors->has('logo'))
                            <span class="invalid-feedback" role="alert"  style="display: block;"><strong>{{ $errors->first('logo') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <label for="">Agrega tu presentación o pitch deck (PDF, JPG)  <span class="required">*</span></label>
                <div class="row">
                    <div class="col-md-4">
                        @if(isset($item->presentacion_file))
                            @if(file_exists(public_path($item->presentacion_file)))
                                <?php $archivo = explode('.',$item->presentacion_file)?>
                                @if($archivo[1]=='pdf')
                                    <a class="btn btn-sm btn-primary" href="{{url($item->presentacion_file)}}" target="_blank"><i class="fa fa-search-plus"></i> Ver Presentación</a>
                                    <input type="hidden" name="presentacion_file" value="{{$item->presentacion_file}}" />
                                @else
                                    <img src="{{url($item->presentacion_file)}}?{{str_random(15)}}" width="120" height="120" border="0" alt="" class="rounded img-fluid" data-action="zoom" />
                                @endif
                            @endif
                        @else
                            <img src="https://imgplaceholder.com/240x250/37bc9b/ffffff/fa-file-pdf-o?text=_none_&font-size=60" width="120" height="120" border="0" alt="" />
                        @endif
                    </div>
                    <div class="col-md-8">
                        <input type='file' name="presentacion" id="" accept=".pdf, .jpg, .jpeg" required="required" />
                        @if ($errors->has('presentacion'))
                            <span class="invalid-feedback" role="alert" style="display: block;"><strong>{{ $errors->first('presentacion') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>