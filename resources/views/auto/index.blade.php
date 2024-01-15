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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Marca</th>
										<th>Modelo</th>
										<th>Año</th>
										<th>Kilometros</th>
										<th>Motor</th>
										<th>Combustible</th>
										<th>Precio</th>
										<th>Activo</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($autos as $auto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
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
                {!! $autos->links() !!}
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function setActive(autoId) {
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
