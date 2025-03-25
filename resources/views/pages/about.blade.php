@extends('layouts.app')
@section('content')
    <main>
        <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-text" href="{{ route('home') }}">
                            <i class="fa fa-home" aria-hidden="true"></i> Acceuil</a>
                        </li>
                        <li class="breadcrumb-item">{{ $page->name }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10 bg-light">
            <div class="container">
                <h1 class="my-3">{{ $page->name }}</h1>
                <p>{!! $page->content !!}</p>
            </div>
        </section>
    </main>
@endsection
