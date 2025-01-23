@extends('layouts.master')
@section('content')
    <div class="destination-container">
        <div class="header">
            @webp
            <picture>
                <source media="(min-width: 768px)"
                        srcset="{{$destination->header_image->webps->url}}" type="image/webp">
                <source media="(min-width: 620px)"
                        srcset="{{$destination->header_image->webps->thumbnail_1150}}" type="image/webp">
                <source media="(min-width: 320px)"
                        srcset="{{$destination->header_image->webps->thumbnail_768}}" type="image/webp">


                <img src="{{$destination->header_image->webps->url}}" alt="{{$destination->name}}"
                     title="{{$destination->header_image->title}}"
                     class="cover-img">
            </picture>
            @else
                <picture>
                    <source media="(min-width: 768px)" srcset="{{$destination->header_image->url}}">
                    <source media="(min-width: 620px)" srcset="{{$destination->header_image->thumbnail_1150}}">
                    <source media="(min-width: 320px)" srcset="{{$destination->header_image->thumbnail_768}}">
                    <img src="{{$destination->header_image->url}}" alt="{{$destination->name}}"
                         title="{{$destination->header_image->title}}"
                         class="cover-img">
                </picture>
                @endwebp
                <div class="header-content">
                    <div class="title section">
                        <div class="small">Explore the most beautiful places of the Adriatic.</div>
                        <h1>{{ $destination->name }}</h1>
                    </div>
                </div>
        </div>
        <div class="content section">
            <div class="destination-right row">
{{--                google mapa prikaz destinacije--}}
{{--                <div id="map" class="column xs12 explore-image">--}}
{{--                </div>--}}

{{--                {{dd($destination->images[count($destination->images)-1]->thumbnail_620)}}--}}
                <img class="column xs12 explore-image" src="{{count($destination->images)==0 ? $destination->header_image->url : $destination->images[count($destination->images)-1]->thumbnail_620}}" alt="{{$destination->header_image->url}}">

                <div class="column xs12 explore-content">
                    <div class="explore-title">
                        <span class="title-light-blue">Explore {{$destination->name}}</span><br>with our cruises
                    </div>
                    <a href="{{route('cruises.index')}}?destinations={{$destination->id}}"
                       class="button">AVAILABLE CRUISES</a>
                </div>
            </div>
            <div class="destination-left">
                @if($destination->description)
                    <div class="destination-text">
                        <p>{!! $destination->description !!}</p>
                    </div>
                @endisset
                <div class="technical-specifications">
                    @if(isset($destination->images) && count($destination->images) > 0)
                        <div class="image-container row">
                            @webp
                            <a

                                    data-lightbox="{{$destination->name}}"
                                    href="{{$destination->header_image->webps->url}}"
                                    class="column xs6 s4 l6 xl4 hide ">

                            </a>
                            @else
                                <a
                                        data-lightbox="{{$destination->name}}"
                                        href="{{$destination->header_image->url}}"
                                        class="column xs6 s4 l6 xl4 hide ">

                                </a>
                                @endwebp
                            @foreach($destination->images as $image)
                                @webp
                                    <a
                                        @if($loop->index==5)
                                            id="destination_trigger"
                                        @endif
                                        data-lightbox="{{$destination->name}}"
                                        href="{{$image->webps->url}}"
                                        class="column xs6 s4 l6 xl4 @if($loop->index>4)hide @endif">
                                            @if($loop->index<5)
                                                <picture>
                                                    <source media="(min-width: 1200px)"
                                                            srcset="{{$image->webps->thumbnail_620}}" type="image/webp">
                                                    <source media="(min-width: 620px)"
                                                            srcset="{{$image->webps->thumbnail_375}}" type="image/webp">
                                                    <source media="(min-width: 320px)"
                                                            srcset="{{$image->webps->thumbnail_320}}" type="image/webp">
                                                    <img src="{{$image->webps->thumbnail_620}}"/>
                                                </picture>

                                            @endif
                                    </a>
                                @else
                                    <a
                                        @if($loop->index==5)
                                            id="destination_trigger"
                                        @endif
                                        data-lightbox="{{$destination->name}}"
                                        href="{{$image->url}}"
                                        class="column xs6 s4 l6 xl4 @if($loop->index>4)hide @endif">
                                        @if($loop->index<5)
                                            <picture>
                                                <source media="(min-width: 1200px)"
                                                        srcset="{{$image->thumbnail_620}}" type="image/webp">
                                                <source media="(min-width: 620px)"
                                                        srcset="{{$image->thumbnail_375}}" type="image/webp">
                                                <source media="(min-width: 320px)"
                                                        srcset="{{$image->thumbnail_320}}" type="image/webp">
                                                <img src="{{$image->thumbnail_620}}"/>
                                            </picture>
                                        @endif
                                    </a>
                                @endwebp
                            @endforeach
                            @if(sizeof($destination->images) > 6)
                                <a class="column xs6 s4 l6 xl4 trigger count-{{sizeof($destination->images)}}"
                                   onclick="$('#destination_trigger').trigger('click')">@svg('assets/more-images.svg',icon)
                                    <span>more images</span></a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include("partials.slider",['slider_title' => 'AVAILABLE CRUISES'])
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3uOto-aRH5hng-7DK5V1uIJp5rUPzCpw">
    </script>
    <script>
        var locations = [{latitude:{{$destination->latitude}}, longitude:{{$destination->longitude}}}]
        document.addEventListener('DOMContentLoaded', () => UI.destinationInit(locations)); // (2)

    </script>
@endsection
