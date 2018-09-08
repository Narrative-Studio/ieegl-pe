<li class="nav-item">
    <a href="{{action('PanelEmprendimientos@DatosGenerales',['id'=>$item->_key])}}" class="nav-link @if($e_active=='generales') active @endif">Datos Generales</a>
</li>
<li class="nav-item">
    <a href="{{action('PanelEmprendimientos@MediosDigitales',['id'=>$item->_key])}}" class="nav-link @if($e_active=='medios') active @endif" href="#">Medios Digitales</a>
</li>
<li class="nav-item">
    <a href="{{action('PanelEmprendimientos@Mercado',['id'=>$item->_key])}}" class="nav-link @if($e_active=='mercado') active @endif" href="#">Mercado</a>
</li>
<li class="nav-item">
    <a href="{{action('PanelEmprendimientos@Inversion',['id'=>$item->_key])}}" class="nav-link @if($e_active=='inversion') active @endif" href="#">Inversión</a>
</li>
<li class="nav-item">
    <a href="{{action('PanelEmprendimientos@Financiera',['id'=>$item->_key])}}" class="nav-link @if($e_active=='financiera') active @endif" href="#">Información Financiera</a>
</li>