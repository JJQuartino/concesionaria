<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">

<title>{{$auto->marca." ".$auto->modelo}} - Autos Jorge</title>
<![endif]-->

</head>
<body>

<!-- LOADER --> 
<div id="loader">
  <div class="position-center-center">
    <div class="ldr"></div>
  </div>
</div>

<!-- Wrap -->
<div id="wrap"> 
  
  @include('layouts.header')
  
  <!-- Content -->
  <main class="cd-main-content"> 
    
    <!-- Popular Products -->
    <section class="padding-top-100 padding-bottom-100">
      <div class="container"> 
        
        <!-- SHOP DETAIL -->
        <div class="shop-detail">
          <div class="row"> 
            
            <!-- Popular Images Slider -->
            <div class="col-md-6"> 
              
              <!-- Place somewhere in the <body> of your page -->
              <div id="slider-shop" class="flexslider">
                <ul class="slides">
                  @foreach($fotos as $foto)
                    <li> <img class="img-responsive" src="{{ asset('storage/images/'.$foto->path)}}" alt=""> </li>
                  @endforeach
                    <!--<li> <img class="img-responsive" src="{{asset('images/productos/04b.jpg')}}" alt=""> </li>-->
                </ul>
              </div>
              <div id="shop-thumb" class="flexslider">
                <ul class="slides">
                  @foreach($fotos as $foto)
                    <li> <img class="img-responsive" src="{{ asset('storage/images/'.$foto->path)}}" alt=""> </li>
                  @endforeach
                </ul>
              </div>
            </div>
            
            <!-- COntent -->
            <div class="col-md-6">
              <h3>{{$auto->marca." ".$auto->modelo}}</h3>
           
              <span class="price">$ {{number_format($auto->precio,0,'','.')}}</span>
              <ul class="item-owner">
                <li><strong>Kilometraje:</strong> {{ number_format($auto->kilometros,0,'','.') }} </li>
                <li><strong>Año:</strong> {{ $auto->año}}	</li>
                <li><strong>Combustible:</strong> {{ ucfirst($auto->combustible) }} </li>
                <li><strong>Motor:</strong> {{ $auto->motor }} </li>
              </ul>
              
             <!-- Short By -->
              <div class="some-info">
                <ul class="row margin-top-30">
                  <li class="col-sm-12">  <span class="price">Descripción: </span></li>
                  @foreach($descripcion as $linea)
                    @if($linea)
                      <li class="col-sm-12"><i class="fa fa-arrow-right"></i> <span>{{ $linea }}</span></li>
                    @endif
                  @endforeach
                </ul>
                <a href={{"https://wa.me/5491133181862?text=Hola.%20Me%20gustaría%20saber%20más%20sobre%20su%20".$auto->marca."%20".$auto->modelo}} style="background-color: rgb(37, 211, 102)" class="btn"><i class="ion-social-whatsapp"></i> ¿Te gustó este auto? ¡Contactanos!</a>
              </div>
            </div>
          </div>
        </div>
        
       
        
      </div>
    </section>
    
  
  <!-- FOOTER -->
@include('layouts.footer')
</main>
  <!-- GO TO TOP  --> 
  <a href="#" class="cd-top"><i class="fa fa-angle-up"></i></a> 
  <!-- GO TO TOP End --> 
  
</div>
</body>
</html>