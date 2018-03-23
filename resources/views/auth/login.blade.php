@extends('layouts.auth')

@section('content')
    <div class="header">
        <div class="logo text-center"><img src="{{URL::asset('klorofil/img/mnc2.png')}}" alt="Klorofil Logo" style="width:140px;"></div>
        <p class="lead">Login to your account</p>
    </div>
    <form class="form-auth-small" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label sr-only">E-Mail Address</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label sr-only">Password</label>

            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group clearfix">
            <label class="fancy-checkbox element-left">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
    </form>
@endsection
