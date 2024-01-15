@extends('layouts.app')

@section('template_title')
    {{ $auto->name ?? "{{ __('Show') Auto" }}"" }} 
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Mostrando: <strong>{{ $auto->marca." ".$auto->modelo }}</strong> </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('autos.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Marca:</strong>
                            {{ $auto->marca }}
                        </div>
                        <div class="form-group">
                            <strong>Modelo:</strong>
                            {{ $auto->modelo }}
                        </div>
                        <div class="form-group">
                            <strong>Año:</strong>
                            {{ $auto->año }}
                        </div>
                        <div class="form-group">
                            <strong>Kilometros:</strong>
                            {{ $auto->kilometros }}
                        </div>
                        <div class="form-group">
                            <strong>Motor:</strong>
                            {{ $auto->motor }}
                        </div>
                        <div class="form-group">
                            <strong>Combustible:</strong>
                            {{ $auto->combustible }}
                        </div>
                        <div class="form-group">
                            <strong>Precio:</strong>
                            {{ $auto->precio }}
                        </div>
                        <div class="form-group">
                            <strong>Precio:</strong>
                            {{ $auto->descripcion }}
                        </div>
                        <div class="row">
                            @foreach($fotos as $foto)
                                <img src="{{ asset('storage/images/'.$foto->path) }}" width="400 %;" >
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
