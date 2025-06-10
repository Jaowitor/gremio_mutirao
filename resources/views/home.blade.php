{{-- filepath: resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <nav>
        <div class="nav-wrapper blue">
            <a href="#" class="brand-logo">
                Instituto Grêmio Mutirão
            </a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li>
                    <a class="waves-effect waves-light btn white blue-text text-darken-2" href="{{ route('login') }}">
                        <i class="material-icons left">login</i>Login
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-light btn white blue-text text-darken-2" href="#!">
                        <i class="material-icons left">info</i>Sobre
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row center-align main-banner">
        <div class="col s12 m6">
            <img src="{{ asset('img/fundo.svg') }}" alt="Logo Instituto Grêmio Mutirão" class="responsive-img">
        </div>
        <div class="col s12 m6 valign-wrapper text-banner">
            <span>
                Formando campeões dentro e fora de campo!
            </span>
        </div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush