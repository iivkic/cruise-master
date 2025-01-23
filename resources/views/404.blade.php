@extends('layouts.master')
@section('content')
    <div class="no-site-container">
        <div class="content section">
            @webp
                <img src="/images/error404.webp" alt="404 Croatia Cruise" class="contain-img" />
            @else
                <img src="/images/error404.png" alt="404 Croatia Cruise" class="contain-img" />
            @endwebp

            <p>Seems like we couldn't find the </p>
            <a href="{{route('home')}}" class="button primary">BACK TO HOMEPAGE</a>
        </div>
    </div>
    @include("partials.contact")
@endsection
