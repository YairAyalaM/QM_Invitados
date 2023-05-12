<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Registrar Check-in') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('checkin.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">{{ __('ID del invitado:') }}</label>
                            <input id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}" required autofocus placeholder="{{ __('Ingresa el ID del invitado a hacer check-in') }}" style="margin-bottom: 10px;">

                            @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar Check-in') }}
                                </button>
                            </div>
                        </div>

                    </form>

                    @if(isset($user))
    <div class="alert alert-success mt-3">
        {{ __('Check-in registrado exitosamente.') }}<br>
        {{ __('Nombre del invitado:') }} {{ $user->name }}<br>
        {{ __('Correo electrónico del invitado:') }} {{ $user->email }}<br>
        {{ __('Fecha de registro del invitado:') }} {{ $user->created_at }}
    </div>
@endif


                    @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>