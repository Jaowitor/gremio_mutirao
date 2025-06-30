@extends('layouts.layout-home')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #007BFF;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Instituto Grêmio Mutirão
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="{{ route('login') }}">
                            <i class="fa-solid fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="#!">
                            <i class="fa-solid fa-info-circle"></i> Sobre
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <div class="row align-items-center gy-4 text-md-start">
            <div class="col-md-6">
                <img src="{{ asset('img/fundo.svg') }}" alt="Logo Instituto Grêmio Mutirão" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2>Formando campeões dentro e fora de campo!</h2>
            </div>
        </div>
    </div>
@endsection