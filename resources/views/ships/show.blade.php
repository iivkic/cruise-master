@extends('layouts.master')
@section('content')
    <div class="ship-container">
        <div class="header">

            @webp
            <picture>
                <source media="(min-width: 1150px)"
                        srcset="{{$ship->header_image->webps->url}}" type="image/webp">
                <source media="(min-width: 620px)"
                        srcset="{{$ship->header_image->webps->thumbnail_1150}}" type="image/webp">
                <source media="(min-width: 320px)"
                        srcset="{{$ship->header_image->webps->thumbnail_768}}" type="image/webp">
                <img data-lightbox="{{$ship->name}}" src="{{$ship->header_image->webps->url}}" alt="{{$ship->name}}"
                     title="{{$ship->header_image->title}}"
                     class="cover-img">
            </picture>
            @else
                <picture>
                    <source media="(min-width: 1150px)"
                            srcset="{{$ship->header_image->url}}" type="image/webp">
                    <source media="(min-width: 620px)"
                            srcset="{{$ship->header_image->thumbnail_1150}}" type="image/webp">
                    <source media="(min-width: 320px)"
                            srcset="{{$ship->header_image->thumbnail_768}}" type="image/webp">
                    <img data-lightbox="{{$ship->name}}" src="{{$ship->header_image->url}}" alt="{{$ship->name}}"
                         title="{{$ship->header_image->title}}"
                         class="cover-img">
                </picture>
                @endwebp

            <div class="header-content">
                <div class="title section">
                    <div class="small">The Best Small Cruise Ships in Croatia</div>
                    <h1>MS {{ $ship->name }}</h1>
                </div>
            </div>
        </div>
        <div class="content section">
            <div class="ship-right row">
                <div class="column xs12 explore-image show-s">

                    @webp
                    <picture>
                        <source media="(min-width: 1200px)"
                                srcset="/images/ship_artwork.webp" type="image/webp">
                        <source media="(min-width: 768px)"
                                srcset="/images/ship_artwork_800.webp" type="image/webp">
                        <source media="(min-width: 320px)"
                                srcset="/images/ship_artwork.webp" type="image/webp">

                    <img src="/images/ship_artwork.webp" alt="explore adriatic with {{$ship->name}}"
                         title="{{$ship->header_image->title}}"
                         class="cover-img">
                    @else
                        <picture>
                            <source media="(min-width: 1200px)"
                                    srcset="/images/ship_artwork.png" type="image/webp">
                            <source media="(min-width: 768px)"
                                    srcset="/images/ship_artwork_800.png" type="image/webp">
                            <source media="(min-width: 320px)"
                                    srcset="/images/ship_artwork.png" type="image/webp">

                            <img src="/images/ship_artwork.png" alt="explore adriatic with {{$ship->name}}"
                                 title="{{$ship->header_image->title}}"
                                 class="cover-img">
                        </picture>
                        @endwebp

                </div>
                <div class="column xs12 explore-content">
                    <div class="explore-title">
                        <span class="title-light-blue">Explore Adriatic</span><br>with {{$ship->name}}
                    </div>
                    @if($ship->charter == 1 || !sizeof($cruises))
                        <a href="{{route('contact')}}?subject=Private%20charter%20inquiry%20-%20{{$ship->name}}" class="charter-button button">Send us your private <br> charter inquiry</a>
                    @else
                        <a href="#featured" class="button">AVAILABLE CRUISES</a>
                    @endif

                </div>
            </div>
            <div class="ship-left">
                @isset($ship->description)
                    <div class="ship-text">
                        <p>{!! $ship->description !!}</p>
                    </div>
                @endisset
                <div class="technical-specifications">
                    <p class="title-light-blue">Technical specification</p>
                    <div class="technical-specifications-details row">
                        <div class="column xs7 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/construction.svg')
                            </div>
                            <p class="spec-title">Year of construction/refit:</p>
                            <p class="spec-value">{{ ($ship->build && $ship->build != "")?$ship->build:"N/A" }}</p>
                        </div>
                        <div class="column xs5 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/length.svg')
                            </div>
                            <p class="spec-title">Length:</p>
                            <p class="spec-value">{!! (isset($ship->length) && $ship->length != "")?$ship->length."m":"N/A" !!}</p>
                        </div>
                        <div class="column xs7 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/icon-cabins.svg')
                            </div>
                            <p class="spec-title">Cabins:</p>
                            <p class="spec-value">{!! (isset($ship->cabins_quantity) && $ship->cabins_quantity != "")?$ship->cabins_quantity:"N/A" !!}</p>
                        </div>
                        <div class="column xs5 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/icon-capacity.svg')
                            </div>
                            <p class="spec-title">Cabin sizes:</p>
                            <p class="spec-value">{!! (isset($ship->cabin_size) && $ship->cabin_size != "")?$ship->cabin_size."m<sup>2</sup>":"N/A" !!}</p>
                        </div>
                        <div class="column xs7 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/passengers.svg')
                            </div>
                            <p class="spec-title">Passengers:</p>
                            <p class="spec-value">{!! (isset($ship->capacity) && $ship->capacity != "")?$ship->capacity:"N/A" !!}</p>
                        </div>
                        <div class="column xs5 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/flag.svg')
                            </div>
                            <p class="spec-title">Flag:</p>
                            <p class="spec-value">{!! (isset($ship->flag) && $ship->flag != "")?$ship->flag:"N/A" !!}</p>
                        </div>
                        <div class="column xs7 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/beam.svg')
                            </div>
                            <p class="spec-title">Beam:</p>
                            <p class="spec-value">{!! (isset($ship->width) && $ship->width != "")?$ship->width."m":"N/A" !!}</p>
                        </div>
                        <div class="column xs5 s4 m3">
                            <div class="svg-container">
                                @svg('/assets/speed.svg')
                            </div>
                            <p class="spec-title">Cruising speed:</p>
                            <p class="spec-value">{!! (isset($ship->speed) && $ship->speed != "")?$ship->speed:"N/A" !!}</p>
                        </div>
                    </div>
                    @if(isset($ship->highlights) && $ship->highlights != "")
                        <p class="title-light-blue">Highlights</p>
                        <div class="highlight-details">
                            <p>{!! $ship->highlights !!}</p>
                        </div>
                    @endif
                    @if(isset($ship->equipment) && trim($ship->equipment) != "")
                        <p class="title-light-blue">Equipment</p>
                        <div class="equipment-details">
                            <p>{!! $ship->equipment !!}</p>
                        </div>
                    @endif
                    <div class="charter-section">
                        <h2>Do you want to charter this ship?</h2>
                        <div class="charter-text">
                            <p>Fancy an exclusive holiday on board one of our ships with your family and friends?
                                Do not hesitate to contact us for more information about private charters, we'll be sure to help you pick the perfect match!</p>
                        </div>
                        <a href="{{route('contact')}}?subject=Private%20charter%20inquiry%20-%20{{$ship->name}}" class="button">ENQUIRE NOW</a>
                    </div>

                    @if(isset($ship->images) && count($ship->images) > 0)
                        <div class="image-container row">
                            @webp
                            <a

                                    data-lightbox="{{$ship->name}}"
                                    href="{{$ship->header_image->webps->url}}"
                                    class="column xs6 s4 l6 xl4 hide ">

                            </a>
                            @else
                                <a
                                        data-lightbox="{{$ship->name}}"
                                        href="{{$ship->header_image->url}}"
                                        class="column xs6 s4 l6 xl4 hide ">

                                </a>
                                @endwebp
                                @foreach($ship->images as $image)
                                    @webp
                                    <a
                                            @if($loop->index==5)
                                            id="ship_trigger"
                                            @endif
                                            data-lightbox="{{$ship->name}}"
                                            href="{{$image->webps->url}}"
                                            class="column xs6 s4 l6 xl4 @if($loop->index>4)hide @endif">
                                        @if($loop->index<5)
                                            <picture>
                                                <source media="(min-width: 1200px)"
                                                        srcset="{{$image->webps->thumbnail_620}}" type="image/webp">
                                                <source media="(min-width: 320px)"
                                                        srcset="{{$image->webps->thumbnail_375}}" type="image/webp">
                                                <img src="{{$image->webps->thumbnail_620}}"/>
                                            </picture>

                                        @endif
                                    </a>
                                    @else
                                        <a
                                                @if($loop->index==5)
                                                id="ship_trigger"
                                                @endif
                                                data-lightbox="{{$ship->name}}"
                                                href="{{$image->url}}"
                                                class="column xs6 s4 l6 xl4 @if($loop->index>4)hide @endif">
                                            @if($loop->index<5)
                                                <picture>
                                                    <source media="(min-width: 1200px)"
                                                            srcset="{{$image->thumbnail_620}}" type="image/webp">
                                                    <source media="(min-width: 320px)"
                                                            srcset="{{$image->thumbnail_375}}" type="image/webp">
                                                    <img src="{{$image->thumbnail_620}}"/>
                                                </picture>
                                            @endif
                                        </a>
                                        @endwebp
                                        @endforeach
                                        @if(sizeof($ship->images) > 6)
                                            <a class="column xs6 s4 l6 xl4 trigger count-{{sizeof($ship->images)}}"
                                               onclick="$('#ship_trigger').trigger('click')">@svg('assets/more-images.svg',icon)
                                                <span>more images</span></a>
                                        @endif
                        </div>
                    @endif
                </div>
{{--                @if(count($ship->features) > 0)--}}
{{--                <div class="boat-features">--}}
{{--                    <div class="title">--}}
{{--                        <h2>BOAT FEATURES</h2>--}}
{{--                    </div>--}}
{{--                    <div class="features-container">--}}
{{--                        @foreach($ship->features as $feature)--}}
{{--                        <div class="feature">--}}
{{--                            @svg('/assets/checkmark.svg')--}}
{{--                            <span>{{$feature->naziv}}</span>--}}
{{--                        </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
            </div>
        </div>
    </div>
    @if(sizeof($cruises))
    @include("partials.slider",['slider_title' => 'AVAILABLE CRUISES'])
    @endif
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () =>    UI.shipInit()); // (2)
    </script>
@endsection
