@extends('layouts.master')
@section('content')
    <div class="destinations-container">
        <div class="header section">
            <div class="header-overlay"></div>
            <div class="header-content">
                <div class="title">
                    <div class="small">Explore the most beautiful places of the Adriatic coast.</div>
                    <h1>Amazing locations along the Adriatic coast</h1>
                </div>
            </div>
        </div>
        <div class="destinations-wrapper section">
            <div class="destinations-text">
                <p>Our mission is to give travellers the chance to explore the stunning natural environment and
                    picturesque, charming Mediterranean towns while hopping from one island to another. Cruising is a
                    unique way of travelling and exploring beautiful Adriatic cities as the most popular and easy way to
                    experience Croatia.</p>
            </div>
            <div class="destination-search-container">
                <label for="search-input"></label>
                <input type="text" name="search" id="search-input" placeholder="Search ALL destinations"/>
                @svg('/assets/search.svg', 'search-icon')
            </div>
            <div class="results">
                <div class="cards">
                    <div class="row destinations_container">
                        @foreach($destinations as $destination)
                            <div data-name="{{strtolower($destination->name)}}" class="card destination column order-{{$loop->index}} xs12 m6 l4 xl4 xxl3"><a
                                        class="card-link"
                                        href="{{route("destinations.show","$destination->slug")}}">
                                    <div class="card-header">
                                        @webp
                                        <picture>
                                            <source media="(min-width: 1200px)"
                                                    srcset="{{$destination->header_image->webps->thumbnail_375}}" type="image/webp">
                                            <source media="(min-width: 752px)"
                                                    srcset="{{$destination->header_image->webps->thumbnail_620}}" type="image/webp">
                                            <source media="(min-width: 620px)"
                                                    srcset="{{$destination->header_image->webps->thumbnail_768}}" type="image/webp">
                                            <source media="(min-width: 375px)"
                                                    srcset="{{$destination->header_image->webps->thumbnail_620}}" type="image/webp">
                                            <source media="(min-width: 320px)"
                                                    srcset="{{$destination->header_image->webps->thumbnail_375}}" type="image/webp">

                                            <img src="{{$destination->header_image->webps->url}}" alt="{{$destination->name}}"
                                                 title="{{$destination->header_image->title}}"
                                                 class="cover-img">
                                        </picture>
                                        @else
                                            <source media="(min-width: 1200px)"
                                                    srcset="{{$destination->header_image->thumbnail_375}}">
                                            <source media="(min-width: 752px)"
                                                    srcset="{{$destination->header_image->thumbnail_620}}">
                                            <source media="(min-width: 620px)"
                                                    srcset="{{$destination->header_image->thumbnail_768}}">
                                            <source media="(min-width: 375px)"
                                                    srcset="{{$destination->header_image->thumbnail_620}}">
                                            <source media="(min-width: 320px)"
                                                    srcset="{{$destination->header_image->thumbnail_375}}">

                                            <img src="{{$destination->header_image->url}}" alt="{{$destination->name}}"
                                                 title="{{$destination->header_image->title}}"
                                                 class="cover-img">
                                            @endwebp
                                        @if(false)
                                        <div class="tag {{$destination->tag_class}}">{{$destination->tag_name}}</div>
                                            @endif
                                    </div>

                                    <div class="card-content">
                                        <div class="card-title">
                                            <div class="destination-name">
                                                {{$destination->name}}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="empty-state">
                    <p>Haven't found what you are looking for?</p>
                    <a onclick="UI.clearSearch()">Reset your search</a>
                </div>
            </div>
        </div>
    </div>
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.destinationsInit()); // (2)

    </script>
@endsection
