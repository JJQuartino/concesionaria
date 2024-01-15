<head>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        .image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 10px; /* Add spacing between images if needed */
        }

        .img-responsive {
            max-width: 100%; /* Make the image responsive within its container */
            height: auto; /* Auto-adjust the height to maintain aspect ratio */
            cursor: pointer; /* Change cursor to pointer when hovering over the image */
            /* Add additional styling as needed */
            width: 100%; /* Set a fixed width */
            height: auto; /* Set a fixed height */
            object-fit: cover; /* Maintain aspect ratio and crop as needed */
        }
    </style>
</head>
<div class="container" style="margin-top: 50px;">
    <div class="row">
        
        <div class="col-lg-6">
            <div class="form-group">
                {{ Form::label('marca') }}
                {{ Form::text('marca', $auto->marca, ['class' => 'form-control' . ($errors->has('marca') ? ' is-invalid' : ''), 'placeholder' => 'Marca']) }}
                {!! $errors->first('marca', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('modelo') }}
                {{ Form::text('modelo', $auto->modelo, ['class' => 'form-control' . ($errors->has('modelo') ? ' is-invalid' : ''), 'placeholder' => 'Modelo']) }}
                {!! $errors->first('modelo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('año') }}
                {{ Form::text('año', $auto->año, ['class' => 'form-control' . ($errors->has('año') ? ' is-invalid' : ''), 'placeholder' => 'Año']) }}
                {!! $errors->first('año', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('kilometros') }}
                {{ Form::text('kilometros', $auto->kilometros, ['class' => 'form-control' . ($errors->has('kilometros') ? ' is-invalid' : ''), 'placeholder' => 'Kilometros']) }}
                {!! $errors->first('kilometros', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('motor') }}
                {{ Form::text('motor', $auto->motor, ['class' => 'form-control' . ($errors->has('motor') ? ' is-invalid' : ''), 'placeholder' => 'Motor']) }}
                {!! $errors->first('motor', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('combustible') }}
                {{ Form::text('combustible', $auto->combustible, ['class' => 'form-control' . ($errors->has('combustible') ? ' is-invalid' : ''), 'placeholder' => 'Combustible']) }}
                {!! $errors->first('combustible', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('precio') }}
                {{ Form::text('precio', $auto->precio, ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
                {!! $errors->first('precio', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('descripcion') }}
                {{ Form::textarea('descripcion', $auto->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
                {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            @if(!str_contains(Route::currentRouteName(),"edit"))
                <div class="form-group">
                    {{ Form::label('imagenes')}}
                    {{ Form::file('imagenes[]', ['class' => 'form-control' , 'onchange' => "ValidateSingleInput(this);", 'multiple' => true , 'accept' => "image/x-png,image/gif,image/jpeg"]) }}
                </div>
            @endif
        </div>
        @if(str_contains(Route::currentRouteName(),"edit"))
            <div class="form-group" style="padding-left: 15px;">
                {{ Form::label('Haga click sobre la imagen a reemplazar')}}
                    <div class="row" id="sortableList">
                        @foreach ($fotos as $foto)
                            <li class="image-container col-lg-2">
                                <img class="img-responsive image-clickable" src="{{ asset('storage/images/'.$foto->path)}}" alt="Click to upload">
                                {{ Form::file('imagen', ['class' => 'form-control foto-orden', 'onchange' => "nuevaFoto(this);", 'accept' => 'image/x-png,image/gif,image/jpeg', 'hidden' => true, 'id' => $foto->id]) }}
                            </li>
                        @endforeach
                    </div>
                {{ Form::text('orden', '...', ['class' => 'form-control', 'hidden' => true,'id' => "sortedList"]) }}
            </div>
        @endif
    </div>
    <div class="box-footer mt20" style="padding-top: 10px;">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        <a href="{{url()->previous()}}"><button type="button" class="btn btn-danger" >{{ __('Cancelar') }}</button></a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $('.image-clickable').click(function() {
            $(this).next().click(); // Trigger the file input next to the clicked image
        });
    });

    $(function () {
        $('#sortableList').sortable({
            update: function (event, ui) {
                var arrayOfIds = $.map($(".form-control.foto-orden"), function(n, i){
                    return n.id;
                });
                $("#sortedList").val(arrayOfIds);
            }
        });
    });

    function nuevaFoto(input)
    {
        console.log(input.getAttribute("id"))
        ValidateSingleInput(input)
        const file = input.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('imagen', file);
            formData.append('id', input.getAttribute("id"));
            //alert(formData)
            // Send an AJAX request to a Laravel route
            $.ajax({
                url: '/updatephoto/', // Replace with your actual Laravel route
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Replace with the actual CSRF token
                },
                processData: false,
                contentType: false,
                success: function (response) {
                    // Handle the response from the backend method
                    console.log('Backend response:', response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle errors, if any
                    console.error('Error:', error);
                }
            });
        }
    }

    var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
    function ValidateSingleInput(oInput)
    {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("El archivo " + sFileName + " no es una foto, solo se permiten archivos: " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    return false;
                }
            }
            else{
                alert("No seleccionó ninguna foto");
            }
        }
        return true;
    }
</script>
