@extends('layouts.auth.default')
@section('content')
    <div class="card-body login-card-body">
        <div class="card-body login-card-body">
            <h2>{{$message}}</h2>

            <a href="https://ally.eezly.com/login">
                <button type="button" class="btn btn-warning btn-block">Login</button>
            </a>
        </div>
    </div>

    <script type="text/javascript">
        window.setTimeout(function() {
            window.location.href = 'https://ally.eezly.com/login';
        }, 3000);
    </script>

@endsection


