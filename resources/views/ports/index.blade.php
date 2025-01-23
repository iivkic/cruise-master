@extends('layouts.master')
@section('content')
    <div class="ports-container">
        <div class="header section">
            <div class="header-overlay"></div>
            <div class="header-content">
                <div class="title">
                    <div class="small">Explore the Adriatic Sea</div>
                    <h1>Starting ports</h1>
                </div>
            </div>
        </div>
        <div class="ports-wrapper section">
            <div class="ports-text">
                <p>Our cruises start from {{$ports->count()}} different ports in Croatia - Dubrovnik Omiš, Opatija, Split and Zadar. Choose your
                    starting port and we will show you the list of all our cruises that start from chosen location.
                    Enjoy in exploring your options and find the best small ship cruise for you. Contact us any time if
                    you need help or just a suggestion.</p>
            </div>
            <div class="results">
                <div class="cards">
                    <div class="row ports_container">
                        @foreach($ports as $destination)
                            <div class="card port column order-{{$loop->index}} xs12 m6 l3"><a class="card-link"
                                                                                               href="{{route("destinations.show","$destination->slug")}}">
                                    <div class="card-header">
                                        @webp
                                        <picture>
                                            <source media="(min-width: 1366px)"
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
                                            <picture>
                                                <source media="(min-width: 1366px)"
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
                                            </picture>
                                            @endwebp
                                            @if(false)
                                                <div class="tag {{$destination->tag_class}}">{{$destination->tag_name}}</div>
                                            @endif
                                    </div>

                                    <div class="card-content">
                                        <div class="card-title">
                                            <div class="port-name">
                                                {{$destination->name}}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
{{--            <div class="map-container" id="map">--}}
{{--            </div>--}}
        </div>
    </div>
    @include("partials.slider",["slider_title"=>"AVALIABLE CRUISES"])
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3uOto-aRH5hng-7DK5V1uIJp5rUPzCpw">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () =>    UI.portsInit({!! json_encode($ports) !!})); // (2)

    </script>
@endsection
