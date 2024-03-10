<footer>
    <div class="clearfix"></div>
    <div class="container">
      <div class="row"> 
        <div class="col-md-4">
          <div class="about-footer"> <img class="margin-bottom-30" src="{{asset('images/logo-foot2.png')}}" alt="" >
            <p><i class="icon-pointer"></i> Calle 1234, Ciudad de Buenos Aires.</p>
            <p><i class="icon-call-end"></i> 4231 5678 </p>
            <p><i class="ion-social-whatsapp"></i> (011) 1234 5678</p>
            <p><i class="icon-envelope"></i> ventas@tuconcesionaria.com</p>
          </div>
        </div>
        
        <div class="col-md-5">
          <h6>SERVICIOS</h6>
          <ul class="link">
            <li><a href="/"> Asesoramiento</a></li>
            <li><a href="/"> Financiamiento</a></li>
            <li><a href="/"> Post Venta</a></li>
            <li><a href="/"> Repuestos</a></li>
            <li><a href="/"> Más Servicios</a></li>
          
          </ul>
        </div>
        
        <div class="col-md-3">
          <h6>SOBRE NOSOTROS</h6>
          <ul class="link">
            <li><a href="#."> Sobre Nosotros</a></li>
            <li><a href="#."> Aviso Legal</a></li>
            <li><a href="#."> Formas y planes de Pago</a></li>
            <li><a href="#."> Contáctenos</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="rights">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <p>Desarrollado por <b>QSistemas</b></a></p>
          </div>
        </div>
      </div>
    </div>
</footer>
<script src="{{asset('js/jquery-1.12.4.min.js')}}"></script> 
<script src="{{asset('js/popper.min.js')}}"></script> 
<script src="{{asset('js/bootstrap.min.js')}}" ></script> 
<script src="{{asset('js/own-menu.js')}}"></script> 
<script src="{{asset('js/jquery.lighter.js')}}"></script> 
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script> 
<script src="{{asset('js/owl.carousel.min.js')}}"></script> 
<script src="{{asset('js/lazysizes.min.js')}}"></script> 
<script src="{{asset('js/main.js')}}"></script>
<script>
  function searchbox()
  {
    let input = $('#search').val();
    window.open("/catalogo?marca=" + input, "_self");
  }

  function search(valor, tipo)
  {
    var urlParams = new URLSearchParams(window.location.search);
    const params = urlParams.entries();
    let parametros = "";
    if(typeof params !== "undefined")
    {
      for(const param of params){
        if(`${param[0]}` !== "page" && `${param[0]}` !== tipo)
          parametros += `${param[0]}` + "=" + `${param[1]}` + "&";
          
      }
    }
    let nuevoParam = tipo + "=" + valor;
    let url = "/catalogo?" + parametros + nuevoParam;
    window.open(url, "_self");
  }

  $('.search-link').on('click', function(event) {
    event.preventDefault(); 
    var valor = $(this).attr('id');
    var tipo = $(this).attr('tipo');
    search(valor, tipo);
  });

  $('.search-link').hover(
    function() {
        // Mouse enter - turn yellow
        $(this).css('color', '#ffe115');
        $(this).css('cursor', 'pointer');
    },
    function() {
        // Mouse leave - revert to original color
        $(this).css('color', '');
    }
  );

  $('#ordenar').on('change', function(){
    search($(this).val(),"ordenar");
  });
</script>