@extends('layouts.app')

@section('content')
    <div class="box-centered">
        <div class="rounded" style="border: 1px solid var(--danger)">
            <div class="rounded" style="background: var(--danger); color: var(--light); padding:10px">
                {{ __('Register') }}
            </div>
            <form style="padding: 20px; width: 300px" method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name">{{ __('Name') }}</label>
                    <input class="input @error('name') is-invalid @enderror" id="name" type="text" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span style="color: --var(danger)">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div>
                    <label for="email">{{ __('Email Address') }}</label>
                    <input class="input @error('email') is-invalid @enderror" id="email" type="email" name="email"
                        value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span style="color: --var(danger)">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" class="input" type="password" name="password" required
                        autocomplete="new-password">

                    @error('password')
                        <span style="color: --var(danger)">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div>
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" class="input" type="password" name="password_confirmation" required
                        autocomplete="new-password">
                </div>

                <div>
                    <button type="submit" class="button button-danger">
                        {{ __('Register') }}
                    </button>
                </div>
                <a href="{{ url('login') }}">Already have an account? Login</a>
            </form>
        </div>
    </div>
@endsection
