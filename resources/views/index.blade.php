<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<title>Autos Jorge</title>
</head>
<body>

<div id="loader">
  <div class="position-center-center">
    <div class="ldr"></div>
  </div>
</div> 

<div id="wrap"> 
  
  @include('layouts.header')
  
  <main class="cd-main-content"> 
    
    <section class="simple-head" data-stellar-background-ratio="0.5">
      <div class="position-center-center"> 
        <div class="container-full"> 
          <div class="text-left col-lg-8 no-padding">
            <h4>Tu próximo auto...</h4>
            <h1 class="extra-huge-text">lo tenemos nosotros!</h1>
            <div class="text-btn"> <a href="/catalogo" class="btn btn-inverse margin-top-40">VER AUTOS</a> </div>
          </div>
        </div>
      </div>
    </section>
    
    <div id="content" class="contenedororden" > 
      
      <!--<div id="qck-view-shop" class="zoom-anim-dialog qck-inside mfp-hide">
        <div class="row">
          <div class="col-sm-6"> 
            
            <div class="images-slider">
              <ul class="slides">
                <li data-thumb="images/productos/04.jpg"> <img src="images/productos/04.jpg" alt=""> </li>
                <li data-thumb="images/productos/04b.jpg"> <img src="images/productos/04b.jpg" alt=""> </li>
               
              </ul>
            </div>
          </div>
        </div>
      </div>-->
      
      <!-- New Arrival -->
      <section class="padding-top-100 ordenuno">
        <div class="container-full"> 
          
          <!-- Main Heading -->
          <div class="heading text-center">
            <h4>¡Conocenos!</h4>
      </div>
          
          <!-- New Arrival -->

        </div>
      </section>    
     
      <section class="small-about ordencuatro">
        <div class="container-full">
          <div class="news-letter padding-top-150 padding-bottom-150">
            <div class="row">
              <div class="col-lg-6">
                <h3>Somos una concesionaria con más de 35 años en el rubro de la venta de automóviles. Nuestra trayectoria avalan la dedicación, compromiso, seriedad y responsabilidad que buscas.</h3>
                <ul class="social_icons">
                  <li><a href="#."><i class="ion-social-facebook"></i></a></li>
                  <li><a href="#."><i class="ion-social-instagram"></i></a></li>
                  <li><a href="#."><i class="ion-social-whatsapp"></i></a></li> 
                </ul>
              </div>
              <!--<div class="col-lg-6">
                <h3>Suscribirse a ofertas y novedades</h3>
                <span>¿Querés recibir las mejores ofertas en tu correo electrónico?.</span>
                <form>
                  <input type="email" placeholder="Ingresá tu correo" required>
                  <button type="submit">Suscribirse</button>
                </form>
              </div>-->
            </div>
          </div>
        </div>
      </section>
 
      
      <!-- Clients -->
      <!--<section class="clients light-gray-bg padding-top-60 padding-bottom-80 ordencinco">
        <div class="container-full">
          <div class="clients-slide">
            <div> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Ford_logo_flat.svg/2560px-Ford_logo_flat.svg.png" alt="" > </div>
            <div> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/Chevrolet-logo.png/2560px-Chevrolet-logo.png" alt="" > </div>
            <div> <img src="https://cdn.worldvectorlogo.com/logos/peugeot-8.svg" alt="" > </div>
          </div>
        </div>
      </section>-->
    </div>
    
    <!-- FOOTER -->
    @include('layouts.footer')
    
  </main>
  <!-- GO TO TOP  --> 
  <a href="#" class="cd-top"><i class="fa fa-angle-up"></i></a> 
  <!-- GO TO TOP End --> 


</div>
<script src="js/jquery-1.12.4.min.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js" ></script> 
<script src="js/own-menu.js"></script> 
<script src="js/jquery.lighter.js"></script> 
<script src="js/jquery.magnific-popup.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/lazysizes.min.js"></script> 
<script src="js/main.js"></script>
 <!-- WHATSAPP  --> 
 <div id="myButton"></div>
  <link rel="stylesheet" href="css/floating-wpp.css">
    <script type="text/javascript" src="js/floating-wpp.js"></script>
<script type="text/javascript">
    $(function () {
        $('#myButton').floatingWhatsApp({
            
           
            message: "Hola, ",
            showPopup: true,
            showOnIE: false,
            size:'72px',
            position:'left',
            headerTitle: 'Escribinos por Whatsapp',
            headerColor: '#25D366',
            backgroundColor: '#25D366',
            buttonImage: '<img src="images/whatsapp.svg" />'
        });
    });
</script>
<!-- WHATSAPP End --> 
</body>
</html>