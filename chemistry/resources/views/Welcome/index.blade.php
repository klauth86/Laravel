@extends('layouts.app')

@section('content')

<div class="content">
    <div class="auth">

        <div class="auth__type typo typo_h1">
            <a href="{{ route('auth.facebook') }}">Войти</a>
            через Facebook
        </div>

        <div class="auth__type typo typo_h1">
            <a href="{{ route('auth.test') }}">Тест</a>
        </div>

    </div>
</div>

@endsection
