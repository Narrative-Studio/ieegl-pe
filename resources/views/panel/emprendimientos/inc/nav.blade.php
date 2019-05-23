<div class="icons-tab-steps wizard-circle wizard clearfix" role="application" id="steps-uid-0">
    <div class="steps clearfix">
        <ul role="tablist">
            <li role="tab" class="first @if($e_active>1) done @endif @if($e_active==1) current @endif" aria-disabled="false" aria-selected="true">
                <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" id="steps-uid-0-t-0" href="#steps-uid-0-h-0" aria-controls="steps-uid-0-p-0"><span class="step"><i class="step-icon icon-book-open"></i></span> 1. Datos Generales</a>
            </li>
            <li role="tab" class="@if($e_active>2)  done  @endif @if($e_active==2) current @endif" aria-disabled="true">
                <a href="{{action('PanelEmprendimientos@MediosDigitales',['id'=>$item->_key])}}" id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1"><span class="step"><i class="step-icon icon-globe"></i></span> 2. Medios Digitales</a>
            </li>
            <li role="tab" class="@if($e_active>3) done @endif @if($e_active==3) current @endif" aria-disabled="true">
                <a href="{{action('PanelEmprendimientos@Mercado',['id'=>$item->_key])}}" id="steps-uid-0-t-2" href="#steps-uid-0-h-2" aria-controls="steps-uid-0-p-2"><span class="step"><i class="step-icon icon-target"></i></span> 3. Mercado</a>
            </li>
            <li role="tab" class="@if($e_active>4) done @endif @if($e_active==4) current @endif" aria-disabled="true">
                <a href="{{action('PanelEmprendimientos@Inversion',['id'=>$item->_key])}}" id="steps-uid-0-t-3" href="#steps-uid-0-h-3" aria-controls="steps-uid-0-p-3"><span class="step"><i class="step-icon icon-pie-chart"></i></span> 4. Inversión</a>
            </li>
            <li role="tab" class="@if($e_active>5) done @endif  @if($e_active==5) current @endif last" aria-disabled="true">
                <a href="{{action('PanelEmprendimientos@Financiera',['id'=>$item->_key])}}" id="steps-uid-0-t-4" href="#steps-uid-0-h-4" aria-controls="steps-uid-0-p-4"><span class="step"><i class="step-icon icon-calculator"></i></span> 5. Información Financiera</a>
            </li>
        </ul>
    </div>
</div>