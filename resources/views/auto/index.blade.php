<link href="css/dataTables.dataTables.css" rel="stylesheet">
<script src="js/jquery-3.6.0.min.js"></script>
<script src='js/dataTables.min.js'></script>

@extends('layouts.app')

@section('template_title')
    Auto
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Autos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('autos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nuevo Auto') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body" id="tabla">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr class="custom-tr">
										<th>Marca</th>
										<th>Modelo</th>
										<th>Año</th>
										<th>Kilometros</th>
										<th>Motor</th>
										<th>Combustible</th>
										<th>Precio</th>
										<th>Activo</th>
										<th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($autos as $auto)
                                        <tr class="custom-tr">
                                            
											<td>{{ $auto->marca }}</td>
											<td>{{ $auto->modelo }}</td>
											<td>{{ $auto->año }}</td>
											<td>{{ number_format($auto->kilometros,0,'','.') }}</td>
											<td>{{ $auto->motor }}</td>
											<td>{{ ucfirst($auto->combustible) }}</td>
											<td>$ {{ number_format($auto->precio,0,'','.') }}</td>
											<td><input type="checkbox" @if($auto->activo == 1) checked @endif onclick="setActive({{ $auto->id }})"></td>

                                            <td>
                                                <form action="{{ route('autos.destroy',$auto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " target="_blank" href="{{ route('autos.show',$auto->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Mostrar') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('autos.edit',$auto->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $autos->links() !!} --}}
            </div>
        </div>
    </div>
@endsection
<script>

    $(document).ready(function()
    {
        tabla();
    });

    function tabla()
    {
        let autos = <?php echo json_encode($autos); ?>;
        console.log(autos);
        //autos = autos.data;
        let tabla = $("#tabla table").DataTable();
        return;
        if(tabla){
            tabla.destroy();
        }
        tabla = $("#tabla table").find("tbody");
        tabla.html('');
        let html = "";

        for(let i = 0; i < autos.length; i++){
            const auto = autos[i];
            let esActivo = auto.activo;
            html = '<tr class="custom-tr">';
            html += "<td><b>"+auto.marca+"</b></td>";
            html += "<td><b>"+auto.modelo+"</b></td>";
            html += "<td><b>"+auto.año+"</b></td>";
            html += "<td><b>"+auto.kilometros+"</b></td>";
            html += "<td><b>"+auto.motor+"</b></td>";
            html += "<td><b>"+auto.combustible+"</b></td>";
            html += "<td><b>"+auto.precio+"</b></td>";
            
            if(esActivo)
                esActivo = "checked";
            else
                esActivo = "";
        
            html += "<td><b><input type='checkbox' "+esActivo+" onclick='setActive("+auto.activo+")'></b></td>";
            html += '</tr>';
            tabla.append(html);
        }
                
        $("#tabla table").DataTable();
    }
    
    function setActive(autoId)
    {
        $.ajax({
            url: '/setactive/' + autoId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Replace with the actual CSRF token
            },
            success: function(response) {
                console.log(response)
            },
            error: function(xhr, status, error) {
                console.error('Error updating active status:', error);
            }
        });
    }
</script>
