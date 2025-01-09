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
    <section class="shop-page padding-top-100 padding-bottom-100">
      <div class="container-full">
        <div class="row"> 
          
          <div class="col-md-2 order-sm-2 order-md-1">
            <div class="shop-sidebar"> 
              @if($total > 0)
              <h5 class="shop-tittle margin-bottom-30">Marca</h5>
              <ul class="shop-cate">
                @if(!str_contains(Request::getRequestUri(),"marca"))
                  @foreach($marcas as $marca)
                    <li>
                      <a id="{{$marca->marca}}" tipo="marca" class="search-link"><i class="fa fa-square-o"></i> {{$marca->marca}} <span>@if(!Request::get("marca"))({{$marca->cant}})@endif</span></a>
                    </li>
                  @endforeach
                @endif  
              </ul>
            </div>
            <div class="shop-sidebar"> 
              <h5 class="shop-tittle margin-bottom-30">Precio</h5>
              @if($total > 4)
              <ul class="shop-cate">
                <li>
                  <a id="{{$precios[0]."-".$precios[1]}}" tipo="precio" class="search-link"><i class="fa fa-square-o"></i> ${{number_format($precios[0],0,'','.')}} a ${{number_format($precios[1],0,'','.')}}</a>
                </li>
                <li>
                  <a id="{{$precios[1]."-".$precios[2]}}" tipo="precio" class="search-link"><i class="fa fa-square-o"></i> ${{number_format($precios[1],0,'','.')}} a ${{number_format($precios[2],0,'','.')}}</a>
                </li>
                <li>
                  <a id="{{$precios[2]."-".$precios[3]}}" tipo="precio" class="search-link"><i class="fa fa-square-o"></i> ${{number_format($precios[2],0,'','.')}} a ${{number_format($precios[3],0,'','.')}}</a>
                </li>
              </ul>
              @endif
            </div>
            <div class="shop-sidebar">
              <h5 class="shop-tittle margin-bottom-30">Kilometros</h5>
              @if($total > 4 && Session::get('filtradoKilometros') < 2)
              <ul class="shop-cate">
                <li>
                  <a id="{{$kilometros[0]."-".$kilometros[1]}}" tipo="kilometros" class="search-link"><i class="fa fa-square-o"></i> {{number_format($kilometros[0],0,'','.')}} a {{number_format($kilometros[1],0,'','.')}}</a>
                </li>
                <li>
                  <a id="{{$kilometros[1]."-".$kilometros[2]}}" tipo="kilometros" class="search-link"><i class="fa fa-square-o"></i> {{number_format($kilometros[1],0,'','.')}} a {{number_format($kilometros[2],0,'','.')}}</a>
                </li>
                <li>
                  <a id="{{$kilometros[2]."-".$kilometros[3]}}" tipo="kilometros" class="search-link"><i class="fa fa-square-o"></i> {{number_format($kilometros[2],0,'','.')}} a {{number_format($kilometros[3],0,'','.')}}</a>
                </li>
              </ul>
              @endif
              @endif
            </div>
            <!--<div class="shop-sidebar">
              <h5 class="shop-tittle margin-bottom-30">Años</h5>
              @if($total > 4)
              <ul class="shop-cate">
                @foreach($años as $año)
                  <li>
                    <a id="{{$año->año}}" tipo="año" class="search-link"><i class="fa fa-square-o"></i> {{$año->año}}</a>
                  </li>
                @endforeach
              </ul>
              @endif
            </div>-->
          </div>
          
          <div class="col-md-10 order-sm-1 order-md-2">
            <div class="sidebar-layout"> 
              <div class="item-fltr"> 
                <!-- short-by -->
                <div class="short-by"> Mostrando {{$resultados}} de {{$total}}</div>
                <!-- List and Grid Style -->
                <div class="lst-grd"> <a href="#" id="list"><i class="flaticon-interface"></i></a> <a href="#" id="grid"><i class="icon-grid"></i></a> 
                  <!-- Select -->
                  <select id="ordenar">
                    <option @if(str_contains(Request::getRequestUri(),"pMam")) selected @endif value="pMam">Ordenar por Precio: Mayor a menor</option>
                    <option @if(str_contains(Request::getRequestUri(),"pmaM")) selected @endif value="pmaM">Ordenar por Precio: Menor a mayor</option>
                    <option @if(str_contains(Request::getRequestUri(),"kMam")) selected @endif value="kMam">Ordenar por Kilometraje: Mayor a menor</option>
                    <option @if(str_contains(Request::getRequestUri(),"kmaM")) selected @endif value="kmaM">Ordenar por Kilometraje: Menor a mayor</option>
                  </select>
                </div>
              </div>

              @if($total <= 0)
                <h1>Sin resultados</h1>  
              @endif
              
              <!-- Item -->
              <div id="products" class="arrival-block col-item-4 list-group">
                <div class="row"> 

                  <!-- Item -->
                  @foreach ($autos as $auto)
                    <div class="item">
                        <div class="img-ser">
                            <div class="thumb">
                                <a href="{{ URL('detalle/'.$auto->id)}}">
                                  <img class="" src="{{ asset('storage/images/'.$auto->foto)}}" alt="{{$auto->marca." ".$auto->modelo}}">
                                </a>
                            </div>
                            <div class="item-name fr-grd">
                                <a href="{{ URL('detalle/'.$auto->id)}}" class="i-tittle"><span class="shop-cate">{{$auto->marca." ".$auto->modelo}}</span></a>

                                <span class="price"><span class="line-through">${{$auto->precio*1.4}}</span>${{$auto->precio}}</span>
                            </div>
                            <div class="cap-text">
                                <div class="item-name">
                                    <a href="{{ URL('detalle/'.$auto->id)}}" class="i-tittle">{{$auto->marca." ".$auto->modelo}}</a>
                                    <span class="price"><span class="line-through">${{$auto->precio*1.4}}</span>${{$auto->precio}}</span>
                                    <ul class="list-style" style="text-align: left;">
                                        <li><strong>Kilometraje:</strong> {{number_format($auto->kilometros,0,'','.')}}</li>
                                        <li><strong>Año:</strong> {{$auto->año}}</li>
                                        <li><strong>Combustible:</strong> {{$auto->combustible}}</li>
                                        <li><strong>Motor:</strong> {{$auto->motor}}</li>                                                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
              </div>
              {{$autos->links()}}
              <!-- Pagination 
              <ul class="pagination">
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">...</a></li>
                <li><a href="#">></a></li>
              </ul>-->
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