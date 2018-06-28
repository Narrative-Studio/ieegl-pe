@if (isset($errors) && count($errors->all()) > 0)
    <div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="alert-heading">Por favor corrige estos errores:</h4>
        <ul>
            @foreach ($errors->all('<li>:message</li>') as $message)
                {!! $message !!}
            @endforeach
        </ul>
    </div>
@elseif (!is_null(Session::get('status_error')))
    <div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        @if (is_array(Session::get('status_error')))
            <ul>
                @foreach (Session::get('status_error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ Session::get('status_error') }}
        @endif
    </div>
@endif

@if (!is_null(Session::get('status_success')))
    <div class="alert alert-icon-left alert-success alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-check-circle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        @if (is_array(Session::get('status_success')))
            <ul>
                @foreach (Session::get('status_success') as $success)
                    <li>{{ $success }}</li>
                @endforeach
            </ul>
        @else
            {{ Session::get('status_success') }}
        @endif
    </div>
@endif

@if (!is_null(Session::get('status_warning')))
    <div class="alert alert-icon-left alert-warning alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            @if (is_array(Session::get('status_warning')))
                <ul>
                    @foreach (Session::get('status_warning') as $warning)
                        <li> {{ $warning }}</li>
                    @endforeach
                </ul>
            @else
                {{ Session::get('status_warning') }}
            @endif
        </div>
    </div>
@endif