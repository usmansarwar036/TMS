@extends('layouts.app')

@section('content')
    <div class="box-centered">
        <div class="rounded" style="border: 1px solid var(--success)">
            <div class="rounded bb" style="background: var(--success); color: var(--light); padding:10px">
                {{ __('Login') }}
            </div>
            <form style="padding: 20px; width: 300px" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email">{{ __('Email Address') }}</label>
                    <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus>

                    @error('email')
                        <span style="color: var(--danger)">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" class="input" type="password" name="password" required
                        autocomplete="current-password">

                    @error('password')
                        <span style="color: var(--danger)">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="button button-success">
                        {{ __('Login') }}
                    </button>
                </div>
                <a href="{{ url('register') }}">Not have an account? Sign up</a>
            </form>
        </div>
    </div>
@endsection
