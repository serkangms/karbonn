@extends('theme.app')

@section('content')
    <section class="hero_single office">
        <div class="wrapper">
            <div class="container">
                <h1>{{$page->title}}</h1>
                <p>Vanno helps grow your business using customer reviews</p>
            </div>
        </div>
    </section>
    <!-- /hero_single -->

    <div class="container margin_80">
        <div class="row d-flex align-items-center">
            <div class="col-lg-12">
                <h2>{{$page->title}}</h2>
                <div>
                    {!! $page->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection
