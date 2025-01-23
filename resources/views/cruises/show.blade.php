@extends('layouts.master')
@section('content')
    <?php
    $isGulet=in_array($cruise->main_excursion->partner_id, config('app.gulet_partners'));

    if($cruise->ch_ship_id==74){
        $private=1;
    }else{
        $private=0;
    }

    ?>
    <div class="cruise-container">
        <div class="header section hide-s">
        @webp
        <img src="{{$cruise->ship->header_image->webps->url}}" />
        @else
            <img src="{{$cruise->ship->header_image->url}}" />
        @endwebp

                @if($cruise->prices->max("popust")>0)
                    <div class="discount-card desktop">
                        <div class="circle">!!!</div>
                        <div class="text"><strong>Booking discount available</strong></div>
                        <div class="subtext">Save up to {{(int)$cruise->prices->max("popust")}}%.</div>
                        <div class="line"></div>
                        <div class="fsb">
                            <a href="#prices">@svg('assets/date.svg')</a> <a href="#prices" class="button link">VIEW PRICES</a>
                        </div>
                    </div>

                    <div class="discount-card mobile">
                        <div class="circle">!!!</div>
                        <a href="#prices">
                       <div class="text">
                          <strong>{{(int)$cruise->prices->max("popust")}}% discount available
                          </strong>
                       </div>
                        </a>


                    </div>

                @endif
        </div>

        <div class="header section show-s" style="background: unset; height: calc(100vh - 358px);">
            @webp
            <img src="{{$cruise->ship->header_image->webps->url}}" />
            @else
                <img src="{{$cruise->ship->header_image->url}}" />
                @endwebp

                @if($cruise->prices->max("popust")>0)
                    <div class="discount-card desktop">
                        <div class="circle">!!!</div>
                        <div class="text"><strong>Booking discount available</strong></div>
                        <div class="subtext">Save up to {{(int)$cruise->prices->max("popust")}}%.</div>
                        <div class="line"></div>
                        <div class="fsb">
                            <a href="#prices">@svg('assets/date.svg')</a> <a href="#prices" class="button link">VIEW PRICES</a>
                        </div>
                    </div>

                    <div class="discount-card mobile">
                        <div class="circle">!!!</div>
                        <a href="#prices">
                            <div class="text">
                                <strong>{{(int)$cruise->prices->max("popust")}}% discount available
                                </strong>
                            </div>
                        </a>


                    </div>

                @endif
        </div>
                <div class="h1-title">
                    {{--                <div class="small">Over 100 amazing cruises in Croatia</div>--}}
                    <h1>
                        @if($private==1)
                            {{$cruise->ship->name}} Private Charter
                        @elseif(!$isGulet)
                            Cruise from {{$cruise->start->name}} to {{$cruise->finish->name}} with {{$cruise->ship->name}}
                        @else
                            {{$cruise->ship->name}} Gulet Cruise
                        @endif
                    </h1>
                    <div class="route">
                        <div class="route-pin">@svg('assets/pin-yallow.svg')</div>

                        <div>
                            @foreach($cruise->destinations as $destination)
                                {{ $loop->index!=0 ? ' - ' : '' }}
                                {{ $destination->name }}
                            @endforeach
                        </div>
                    </div>
                </div>

        <div class="nav-second">
            <div class="nav-item">
                <a class="active" href="#overview">OVERVIEW</a>
            </div>
            <div class="nav-item">
                <a href="#route">ROUTE</a>
            </div>
            <div class="nav-item">
                <a href="#itinerary">ITINERARY</a>
            </div>
            <div class="nav-item">
                <a href="#inclusions">INCLUSIONS</a>
            </div>
            <div class="nav-item">
                <a href="#prices">PRICING</a>
            </div>
            <div class="nav-item">
                <a href="#ship">SHIP INFO</a>
            </div>
            <div class="nav-item">
                <a href="#gallery">GALLERY</a>
            </div>
        </div>

        <div class="cruise-content-container">
            <div class="card-section section {{$isGulet?'pb32':''}}">
                <div class="card cruise column  xs12 m6 l6 xl4 xxl3 ">
                    <div class="card-link">
                        <div class="card-header" id="boatSlick">

                            @foreach($cruise->ship->images3 as $image)

                                @webp
                                    <picture class="picture">
                                        <source media="(min-width: 1199px)"
                                                srcset="{{$image->webps->thumbnail_375}}" type="image/webp">
                                        <source media="(min-width: 768px)"
                                                srcset="{{$image->webps->thumbnail_1150}}" type="image/webp">
                                        <source media="(min-width: 620px)"
                                                srcset="{{$image->webps->thumbnail_768}}" type="image/webp">
                                        <source media="(min-width: 375px)"
                                                srcset="{{$image->webps->thumbnail_620}}" type="image/webp">
                                        <source media="(min-width: 320px)"
                                                srcset="{{$image->webps->thumbnail_375}}" type="image/webp">
                                        <img src="{{$image->webps->thumbnail_375}}"
                                             alt="{{$cruise->ship->name}} My Croatia Cruise" class="cover-img">
                                    </picture>

                                @else
                                    <picture class="picture">
                                        <source media="(min-width: 1199px)"
                                                srcset="{{$image->thumbnail_375}}">
                                        <source media="(min-width: 768px)"
                                                srcset="{{$image->thumbnail_1150}}">
                                        <source media="(min-width: 620px)"
                                                srcset="{{$image->thumbnail_768}}">
                                        <source media="(min-width: 375px)"
                                                srcset="{{$image->thumbnail_620}}">
                                        <source media="(min-width: 320px)"
                                                srcset="{{$image->thumbnail_375}}">
                                        <img src="{{$image->thumbnail_375}}"
                                             alt="{{$cruise->ship->name}} My Croatia Cruise" class="cover-img">
                                    </picture>
                                @endwebp
                            @endforeach
                            @if($cruise->prices->max("popust")>0)
                                <div class="tag">{{($cruise->last_minute_deal == 1)?"Special offer":"Great value"}}</div>
                            @endif
                            @if($cruise->great_bargain == 1)
                                <div class="tag {{$cruise->great_bargain == 1 ? "recommend" : ""}}">@svg('assets/dollar.svg'){{($cruise->great_bargain == 1 ? "Great bargain": "")}}</div>
                            @endif
                        </div>

                        <div class="card-content show-xs hide-m show-l">
{{--                            <div class="rating-wrapper fsb">--}}
{{--                                <div class="rating"><span>4.{{5+$cruise->id%5}}</span>--}}
{{--                                    @svg('assets/star.svg','star')--}}
{{--                                </div>--}}
{{--                                <span>(based on {{$cruise->rating_number?:$cruise->id*13}} reviews)</span>--}}
{{--                            </div>--}}


                            @if(!$isGulet)
                            <div class="line"></div>
                            <div class="row-icon fsb">
                                <div class="label">@svg('assets/date.svg',' date-icon icon')<span>Date</span>
                                </div>
                                @if(!in_array($cruise->main_excursion->partner_id, config('app.gulet_partners')))
                                <div class="value">From {{$cruise->departures->min("date")->format("F")}}
                                    to {{$cruise->departures->max("date")->format("F")}}</div>
                                @endif
                            </div>
                            @endif

                            <div class="line"></div>
                            <div class="row-icon fsb">
                                <div class="label">@svg('assets/duration.svg',' icon') <span>Duration</span>
                                </div>
                                <div class="value">{{$cruise->duration->short}}</div>
                            </div>
                            <div class="line"></div>
                            <div class="row-icon fsb">
                                <div class="label">@svg('assets/category.svg',' icon') <span>Category</span>
                                </div>
                                <div class="value">{{$cruise->ship->category->name}}</div>
                            </div>

                            <div class="line"></div>
                            @if(!$isGulet)
                                <div class="price-container">
                                    @if($cruise->min_price->popust>0)
                                        <div class="discount">
                                            <div>save up
                                                to {{(int)$cruise->min_price->popust}}%
                                            </div>
                                            @if($cruise->min_price->popust>0)
                                                <div class="original_price">
                                                    <?=show_currency_price($cruise->min_price->price, "striketrough", "EUR")?>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if($cruise->min_price->real_price)
                                    <div class="prices">
                                        <div class="label">Price from</div>
                                        <div class="price">
                                            <?=show_currency_price($cruise->min_price->real_price, null, "EUR")?>
                                        </div>
                                    </div>
                                        @endif
                                </div>
                            @endif
                        </div>
                        <div class="card-content row show-m hide-l">
                            <div class="column m8">
                                <div class="row-icon fsb">
                                    <div class="label">@svg('assets/date.svg',' date-icon icon')<span>Date</span>
                                    </div>
                                    @if(!$isGulet)
                                    <div class="value">From {{$cruise->departures->min("date")->format("F")}}
                                        to {{$cruise->departures->max("date")->format("F")}}</div>
                                    @endif
                                </div>
                                <div class="line"></div>
                                <div class="row-icon fsb">
                                    <div class="label">@svg('assets/duration.svg',' icon') <span>Duration</span>
                                    </div>
                                    <div class="value">{{$cruise->duration->name}}</div>
                                </div>
                                <div class="line"></div>
                                <div class="row-icon fsb">
                                    <div class="label">@svg('assets/category.svg',' icon') <span>Category</span>
                                    </div>
                                    <div class="value">{{$cruise->category->name}}</div>
                                </div>
                                <div class="line"></div>
                            </div>
                            <div class="column m4">
{{--                                <div class="rating-wrapper fsb">--}}
{{--                                    <div class="rating"><span>4.{{5+$cruise->id%5}}</span>--}}
{{--                                        @svg('assets/star.svg','star')--}}
{{--                                    </div>--}}
{{--                                    <span>(based on {{$cruise->rating_number?:$cruise->id*13}} reviews)</span>--}}
{{--                                </div>--}}

                                @if(!$isGulet)
                                <div class="price-container">

                                    <div class="discount prices">
                                        <div class="label">Price from</div>
                                        @if($cruise->min_price->popust>0)
                                            <div class="original_price">
                                                <?=show_currency_price($cruise->min_price->price, "striketrough", "EUR")?>
                                            </div>
                                        @endif
                                        <div class="price">
                                            <?=show_currency_price($cruise->min_price->real_price, null, "EUR")?>
                                        </div>
                                    </div>
                                    @if($cruise->prices->max("popust")>0)
                                        <div class="discount">
                                            <div>save up
                                                to {{(int)$cruise->prices->max("popust")}}%
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="line"></div>
                    <div class="card-footer">
                        <a href="/#" class="button primary inquiry-button">BOOK INQUIRY</a>
                    </div>
                    <div class="line"></div>
                    <div class="card-content show-xs hide-m show-l">


                        <div class="row-icon trip-wishlist-social fsb">
                            <div class="label wishlist-text">@if(isset(session()->get("wishlist",[])[$cruise->id]))
                                    Remove
                                    from @else Add to @endif wishlist
                            </div>
                            <div class="value">
                                @if(!$isGulet)
                                    <div onclick="UI.toggleWishlist({{$cruise->id}}, '{{$cruise->ship->name." (".$cruise->start->name." to ".$cruise->finish->name.")"}}')" class="add-to-wishlist wishlist_{{$cruise->id}}">
                                 @else
                                    <div onclick="UI.toggleWishlist({{$cruise->id}}, '{{$cruise->ship->name}}')" class="add-to-wishlist wishlist_{{$cruise->id}}">
                                 @endif
                                     @if(isset(session()->get("wishlist",[])[$cruise->id]))
                                        @svg('assets/favorite.svg','active')@else @svg('assets/favorite.svg') @endif
                                </div>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="row-icon fsb">
                            <div class="label">Share
                            </div>
                            <div class="value">
                                <div class="shares"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content row show-m hide-l">

                        <div class="column m8 row-icon fsb">
                            <div class="label">@if(isset(session()->get("wishlist",[])[$cruise->id]))Remove
                                from @else Add to @endif wishlist
                            </div>
                        </div>
                        <div class="column m4 trip-wishlist-social value rating-wrapper">
                            @if(!$isGulet)
                            <div onclick="UI.toggleWishlist({{$cruise->id}}, '{{$cruise->ship->name." (".$cruise->start->name." to ".$cruise->finish->name.")"}}')" class=" text-right add-to-wishlist wishlist_{{$cruise->id}}">
                             @else
                                <div onclick="UI.toggleWishlist({{$cruise->id}}, '{{$cruise->ship->name}}')" class=" text-right add-to-wishlist wishlist_{{$cruise->id}}">
                             @endif
                                 @if(isset(session()->get("wishlist",[])[$cruise->id]))
                                    @svg('assets/favorite.svg','active')@else @svg('assets/favorite.svg') @endif
                            </div>
                        </div>

                    </div>
                    <div class="line show-m hide-l"></div>
                    <div class="card-content row show-m hide-l">
                        <div class="column m8 row-icon fsb">
                            <div class="label">Share
                            </div>
                        </div>
                        <div class="column m4 rating-wrapper value">
                            <div class="shares text-right"></div>
                        </div>

                    </div>


                </div>
                <div class="sticky-booking-container card cruise column">
                    @if($cruise->prices->max("popust")>0)
                    <div class="subcard discount-subcard discount-card">
                        <div class="circle">!!!</div>
                        <div class="text"><strong>Booking discount available</strong></div>
                        <div class="subtext">Save up to {{(int)$cruise->prices->max("popust")}}% on selected dates.</div>
                    </div>
                    @endif
                    <div class="subcard">
                        <div class="card-link">
                            <div class="card-content show-xs hide-m show-l">
{{--                                <div class="rating-wrapper fsb">--}}
{{--                                    <div class="rating"><span>4.{{5+$cruise->id%5}}</span>--}}
{{--                                        @svg('assets/star.svg','star')--}}
{{--                                    </div>--}}
{{--                                    <span>(based on {{$cruise->rating_number?:$cruise->id*13}} reviews)</span>--}}
{{--                                </div>--}}

                                <div class="cruise-name-container">
                                    Cruise from {{ $cruise->start->name }} to {{ $cruise->finish->name }}
                                </div>
                                @if(!in_array($cruise->main_excursion->partner_id, config('app.gulet_partners')))
                                    <div class="line"></div>

                                    <div class="price-container">
                                        @if($cruise->min_price->popust>0)
                                            <div class="discount">
                                                <div></div>
                                                <div class="original_price">
                                                    <?=show_currency_price($cruise->min_price->price, "striketrough", "EUR")?>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="prices">
                                            <div class="label">Price from</div>
                                            <div class="price">
                                                <?=show_currency_price($cruise->min_price->real_price, null, "EUR")?>
                                            </div>
                                        </div>
                                        @if($cruise->min_price->popust>0)
                                            <div class="discount">
                                                <div></div>
                                                <div class="subtext">
                                                        on selected dates
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="line"></div>
                        <div class="card-footer">
                            <a href="#" class="button primary inquiry-button">BOOK INQUIRY</a>
                        </div>
                        <div class="line"></div>
                        <div class="card-content show-xs hide-m show-l">
                        <div class="row-icon trip-wishlist-social fsb">
                            <div class="label wishlist-text">@if(isset(session()->get("wishlist",[])[$cruise->id]))
                                    Remove
                                    from @else Add to @endif wishlist
                            </div>
                            <div class="value">
                                @if(!$isGulet)
                                    <div onclick="UI.toggleWishlist({{$cruise->id}}, '{{$cruise->ship->name." (".$cruise->start->name." to ".$cruise->finish->name.")"}}')" class="add-to-wishlist wishlist_{{$cruise->id}}">
                                        @else
                                            <div onclick="UI.toggleWishlist({{$cruise->id}}, '{{$cruise->ship->name}}')" class="add-to-wishlist wishlist_{{$cruise->id}}">
                                                @endif
                                                @if(isset(session()->get("wishlist",[])[$cruise->id]))
                                                    @svg('assets/favorite.svg','active')@else @svg('assets/favorite.svg') @endif
                                            </div>
                                    </div>
                            </div>
                            <div class="line"></div>
                            <div class="row-icon fsb">
                                <div class="label">Share
                                </div>
                                <div class="value">
                                    <div class="shares"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="cards-wrapper section">


                <div id="overview" class="overview-section">
                    <div class="overview-gallery">

                        <img src="{{ $cruise->ship->header_image->webps->thumbnail_1150 }}" alt="www" class="src">

                        <div class="overview-gallery-items">

                            <div class="overview-title">
                                Overview
                            </div>

                        </div>
                    </div>



                    <div class="overview-details">

                        <div class="overview-items">
                            <div class="overview-item">
                                <div class="overview-icon">@svg('/assets/boat-blue.svg')</div>
                                <div class="overview-icon-title">Ship <br>{{ $cruise->ship->name }}</div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-icon">@svg('/assets/pin-blue.svg')</div>
                                <div class="overview-icon-title">{{ $cruise->translations[0]->islands_cities }}</div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-icon">@svg('/assets/calendar.svg')</div>
                                <div class="overview-icon-title">{{$cruise->departures->min("date")->format("M j")}} - <br>
                                    {{$cruise->departures->max("date")->format("M j")}}</div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-icon">@svg('/assets/money.svg')</div>
                                <div class="overview-icon-title">from <br>
                                    <?=show_currency_price($cruise->min_price->real_price, null, "EUR")?></div>
                            </div>
                        </div>

                        <div class="overview-items description">
                            {!! $cruise->translations[0]->cruise_description !!}
                        </div>
                    </div>
                </div>
                @if(isset($cruise->itinerary->route_image->url) && !is_null($cruise->itinerary->route_image->url))

                    <div id="route" class="route-image-section ss">
                        <div class="search">
                            <a
                                data-lightbox="route-image"
                                href="{{$cruise->itinerary->route_image->url}}"
                                class="search-svg">
                                @svg('assets/search-overview.svg')
                            </a>
                        </div>
                        <a
                            data-lightbox="route-image"
                            href="{{$cruise->itinerary->route_image->url}}"
                            class="search-svg">
                        <img src="{{ $cruise->itinerary->route_image->webps->thumbnail_1150 }}" alt="{{ $cruise->itinerary->route_image->alt }}">
                        </a>
                        <div class="route-title">
                            Route
                        </div>
                    </div>

                @else

                    <div id="route" class="route-image-section">
                        <div class="search">
                            <a
                                data-lightbox="route-image"
                                href="{{$cruise->route_image->url}}"
                                class="search-svg">
                                @svg('assets/search-overview.svg')
                            </a>
                        </div>

                        <img src="{{ $cruise->route_image->webps->thumbnail_1150 }}" alt="{{ $cruise->route_image->alt }}">

                        <div class="route-title">
                            Route
                        </div>
                    </div>
                @endif
                <?php
                    $old = count($cruise->itineraries)==0?false:true;

                ?>
{{--{{dd($old)}}--}}
            @if( $old || !is_null($cruise->program_id))
                @if($old)
                @foreach($cruise->itineraries as $itinerary)
                    @if($itinerary->year<date("Y")) @continue @endif
                    <div id="itinerary" class="itinerary-section">
                        <div class="subsection">
                            <div class="small-icon show-m">
                                @if(count($cruise->ship->images) > 0)
                                @webp
                                    <img src="{{$cruise->ship->images[0]->webps->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                @else
                                    <img src="{{$cruise->ship->images[0]->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                @endwebp
                                @endif
                            </div>
                            <div class="title main-title">
                                @if($cruise->ch_ship_id==74)
                                    Included
                                @elseif(!in_array($cruise->main_excursion->partner_id, array(12,13,14,15)))
                                    Itinerary
{{--                                    <div class="download-container show-m">--}}
{{--                                        <a download href="{{route("cruises.download",$cruise->slug)}}" class="button link">DOWNLOAD--}}
{{--                                            BROCHURE</a>--}}
{{--                                    </div>--}}
                                    <span class="expand-button show-m">expand all</span>

                                @else
                                    Itinerary
{{--                                    <div class="download-container">--}}
{{--                                        <a download href="{{route("cruises.download",$cruise->slug)}}" class="button link">DOWNLOAD--}}
{{--                                            BROCHURE</a>--}}
{{--                                    </div>--}}

{{--                                    <span class="expand-button show-m">expand all</span>--}}


                                @endif
{{--                                <span class="expand-button show-m">expand all</span>--}}
                            </div>
                            <div class="line"></div>
                            @if($cruise->ch_ship_id!=74)
                                @php
                                    $brDana=count($itinerary->days);
                                    $idSlikaZadnjeDestinacije=0;
                                @endphp
                                @foreach($itinerary->days as $day)
                                    <div class="expendable {{ $day->sequence==1 ? 'active' : '' }}" >

                                        <div class="title day" onclick="UI.expand(this)">
                                            @if(!$isGulet)

                                                <div class="day-details">
                                                    <div class="day-title">Day {{$day->sequence}}
                                                        - {{$cruise->departures->first()->date->add($loop->index." days")->format("l")}}
                                                    </div>

                                                    <div class="arrival">
                                                        @if($day->sequence==1)
                                                            <div class="start-title">{{$day->destinations[0]->name}} Arrival</div>
                                                        @else
                                                            @foreach($day->destinations as $destination)
                                                                <div class="start-title">@if($loop->index != 0){{", "}} @endif{{$destination->name}}</div>
                                                            @endforeach
                                                        @endif
                                                        <div class="start-finish {{ $day->sequence==1 ? 'start' : ($day->sequence==count($itinerary->days) ? 'finish' : 'hide') }}">{{ $day->sequence==1 ? 'START' : ($day->sequence==count($itinerary->days) ? 'FINISH' : '') }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div><span>Route {{$day->sequence}}</span>
                                                    <span class="show-m">
                                                        @foreach($day->destinations as $destination){{$loop->index!=0?" - ":""}}{{$destination->name}}@endforeach
                                                    </span>
                                                    <span class="hide-m">
                                                       {{$day->destinations[0]['name']}} - {{$day->destinations[count($day->destinations)/2 - 1]['name']}} - {{$day->destinations[count($day->destinations) - 1]['name']}}
                                                    </span>
                                                </div>
                                            @endif
                                                @svg('assets/choose-month-arrow.svg','expand')
                                        </div>

                                        <div class="day-content">
                                            <div class="day-image">
                                                @php
                                                $zadnjaDestinacija=count($day->destinations);
                                                @endphp
                                                @if(isset($day->destinations[$zadnjaDestinacija-1]->images[0]))
                                                    @if($idSlikaZadnjeDestinacije==$day->destinations[$zadnjaDestinacija-1]->id)
                                                        <img src="{{ $day->destinations[$zadnjaDestinacija-1]->images[1]->webps->thumbnail_768 }}" alt="">
                                                    @else
                                                        <img src="{{ $day->destinations[$zadnjaDestinacija-1]->images[0]->webps->thumbnail_768 }}" alt="">
                                                    @endif
                                                    @php $idSlikaZadnjeDestinacije=$day->destinations[$zadnjaDestinacija-1]->id @endphp
                                                @endif
                                            </div>
                                            <div class="day-details">
{{--                                                <div class="label">--}}
{{--                                                    @foreach($day->meals as $meal){{$loop->index!=0?", ":""}}{{$meal->name}}@endforeach--}}
{{--                                                </div>--}}
                                                <div class="value">{!! $day->text !!}
                                                </div>
                                                @if($loop->index!=$brDana-1)
                                                    <div class="label"> Overnight in {{ $day->destinations[count($day->destinations)-1]['name'] }}.</div>
                                                @endif
                                                <div class="label"> Meals Included:
                                                    @foreach($day->meals as $meal){{$loop->index!=0?", ":""}}{{$meal->name}}@endforeach
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="line"></div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                    <div id="inclusions" class="inclusions-section section">
                        <div class="small-icon show-m">
                            @if(count($cruise->ship->images) > 0)
                                @webp
                                <img src="{{$cruise->ship->images[0]->webps->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                            @else
                                <img src="{{$cruise->ship->images[0]->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                @endwebp
                            @endif
                        </div>
                        <div class="title main-title">
                            Inclusions
                        </div>

                        @if($itinerary->include_ship)
                            <div class="inclusions-item">
                                <div class="title-inclusions">
                                    <label>@svg('assets/plus-circle.svg') General</label>
                                    <div class="line"></div>
                                </div>

                                <div class="details-inclusions">
                                    <?php

                                    $parts=explode("\n", $itinerary->include_ship);
                                    ?>
                                    @foreach($parts as $part)
                                        @svg('assets/check-mark.svg') {{ $part }} <br>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($itinerary->include_meal)
                            <div class="inclusions-item">
                                <div class="title-inclusions">
                                    <label>@svg('assets/spoon-fork.svg') Food & Beverage</label>
                                    <div class="line"></div>

                                </div>

                                <div class="details-inclusions">
                                    <?php
                                    $parts=explode("\n", $itinerary->include_meal);
                                    ?>
                                    @foreach($parts as $part)
                                        @svg('assets/check-mark.svg') {{ $part }} <br>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($itinerary->include_service)
                            <div class="inclusions-item">
                                <div class="title-inclusions">
                                    <label>@svg('assets/services.svg') Service</label>
                                    <div class="line"></div>

                                </div>

                                <div class="details-inclusions">
                                    <?php
                                    $parts=explode("\n", $itinerary->include_service);
                                    ?>
                                    @foreach($parts as $part)
                                        @svg('assets/check-mark.svg') {{ $part }} <br>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($itinerary->include_excursions)
                            <div class="inclusions-item">
                                <div class="title-inclusions">
                                    <label>@svg('assets/excursions.svg') Excursions</label>
                                    <div class="line"></div>

                                </div>

                                <div class="details-inclusions">
                                    <?php
                                    $parts=explode("\n", $itinerary->include_excursions);
                                    ?>
                                    @foreach($parts as $part)
                                        @svg('assets/check-mark.svg') {{ $part }} <br>
                                    @endforeach
                                </div>
                            </div>

                        @endif

                        @if($itinerary->not_include)
                            <div class="inclusions-item">
                                <div class="title-inclusions">
                                    <label>@svg('assets/minus-circle.svg') Price does not include</label>
                                    <div class="line"></div>
                                </div>
                                <div class="details-inclusions">
                                    <?php
                                    $parts=explode("\n", $itinerary->not_include);
                                    ?>
                                    @foreach($parts as $part)
                                        @svg('assets/red-x.svg') {{ $part }} <br>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach
                @else

                        <div id="itinerary" class="itinerary-section">
                            <div class="subsection">
                                <div class="small-icon show-m">
                                    @if(count($cruise->ship->images) > 0)
                                        @webp
                                        <img src="{{$cruise->ship->images[0]->webps->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                    @else
                                        <img src="{{$cruise->ship->images[0]->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                        @endwebp
                                    @endif
                                </div>
                                <div class="title main-title">
                                    @if($cruise->ch_ship_id==74)
                                        Included
                                    @elseif(!in_array($cruise->main_excursion->partner_id, array(12,13,14,15)))
                                        Itinerary
                                        {{--                                    <div class="download-container show-m">--}}
                                        {{--                                        <a download href="{{route("cruises.download",$cruise->slug)}}" class="button link">DOWNLOAD--}}
                                        {{--                                            BROCHURE</a>--}}
                                        {{--                                    </div>--}}
                                        <span class="expand-button show-m">expand all</span>

                                    @else
                                         Itinerary
                                        {{--                                    <div class="download-container">--}}
                                        {{--                                        <a download href="{{route("cruises.download",$cruise->slug)}}" class="button link">DOWNLOAD--}}
                                        {{--                                            BROCHURE</a>--}}
                                        {{--                                    </div>--}}

                                        {{--                                    <span class="expand-button show-m">expand all</span>--}}


                                    @endif
                                    {{--                                <span class="expand-button show-m">expand all</span>--}}
                                </div>
                                <div class="line"></div>
                                @if($cruise->ch_ship_id!=74)
                                    @php
                                        $brDana=count($cruise->itinerary->days);
                                        $idSlikaZadnjeDestinacije=0;
                                    @endphp
                                    @foreach($cruise->itinerary->days as $day)
                                        <div class="expendable {{ $day->sequence==1 ? 'active' : '' }}">

                                            <div class="title day" onclick="UI.expand(this)">
                                                @if(!$isGulet)

                                                    <div class="day-details">
                                                        <div class="day-title">Day {{$day->sequence}}
                                                            - {{$cruise->departures->first()->date->add($loop->index." days")->format("l")}}
                                                        </div>

                                                        <div class="arrival">
                                                            @if($day->sequence==1)
                                                                <div class="start-title">{{$day->destinations[0]->name}} Arrival</div>
                                                            @else
                                                                @foreach($day->destinations as $destination)
                                                                    <div class="start-title">@if($loop->index != 0){{", "}} @endif{{$destination->name}}</div>
                                                                @endforeach
                                                            @endif
                                                            <div class="start-finish {{ $day->sequence==1 ? 'start' : ($day->sequence==count($cruise->itinerary->days) ? 'finish' : 'hide') }}">{{ $day->sequence==1 ? 'START' : ($day->sequence==count($cruise->itinerary->days) ? 'FINISH' : '') }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div><span>Route {{$day->sequence}}</span>
                                                        <span class="show-m">
                                                        @foreach($day->destinations as $destination){{$loop->index!=0?" - ":""}}{{$destination->name}}@endforeach
                                                    </span>
                                                        <span class="hide-m">
                                                       {{$day->destinations[0]['name']}} - {{$day->destinations[count($day->destinations)/2 - 1]['name']}} - {{$day->destinations[count($day->destinations) - 1]['name']}}
                                                    </span>
                                                    </div>
                                                @endif
                                                @svg('assets/choose-month-arrow.svg','expand')
                                            </div>

                                            <div class="day-content">
                                                <div class="day-image">
                                                    @php
                                                        $zadnjaDestinacija=count($day->destinations);
                                                    @endphp
                                                    @if(isset($day->destinations[$zadnjaDestinacija-1]->images[0]))
                                                        @if($idSlikaZadnjeDestinacije==$day->destinations[$zadnjaDestinacija-1]->id)
                                                            <img src="{{ $day->destinations[$zadnjaDestinacija-1]->images[1]->webps->thumbnail_768 }}" alt="">
                                                        @else
                                                            <img src="{{ $day->destinations[$zadnjaDestinacija-1]->images[0]->webps->thumbnail_768 }}" alt="">
                                                        @endif
                                                        @php $idSlikaZadnjeDestinacije=$day->destinations[$zadnjaDestinacija-1]->id @endphp
                                                    @endif
                                                </div>
                                                <div class="day-details">
                                                    {{--                                                <div class="label">--}}
                                                    {{--                                                    @foreach($day->meals as $meal){{$loop->index!=0?", ":""}}{{$meal->name}}@endforeach--}}
                                                    {{--                                                </div>--}}
                                                    <div class="value">{!! $day->text !!}
                                                    </div>
                                                    @if($loop->index!=$brDana-1)
                                                        <div class="label"> Overnight in {{ $day->destinations[count($day->destinations)-1]['name'] }}.</div>
                                                    @endif
                                                    <div class="label"> Meals Included:
                                                        @foreach($day->meals as $meal){{$loop->index!=0?", ":""}}{{$meal->name}}@endforeach
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="line"></div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        <div id="inclusions" class="inclusions-section section">
                            <div class="small-icon show-m">
                                @if(count($cruise->ship->images) > 0)
                                    @webp
                                    <img src="{{$cruise->ship->images[0]->webps->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                @else
                                    <img src="{{$cruise->ship->images[0]->thumbnail_320}}" alt="{{$cruise->ship->images[0]->alt}}" class="src">
                                    @endwebp
                                @endif
                            </div>
                            <div class="title main-title">
                                Inclusions
                            </div>

                            @if($cruise->itinerary->include_ship)
                                <div class="inclusions-item">
                                    <div class="title-inclusions">
                                        <label>@svg('assets/plus-circle.svg') General</label>
                                        <div class="line"></div>
                                    </div>

                                    <div class="details-inclusions">
                                        <?php

                                        $parts=explode("\n", $cruise->itinerary->include_ship);
                                        ?>
                                        @foreach($parts as $part)
                                            @svg('assets/check-mark.svg') {{ $part }} <br>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($cruise->itinerary->include_meal)
                                <div class="inclusions-item">
                                    <div class="title-inclusions">
                                        <label>@svg('assets/spoon-fork.svg') Food & Beverage</label>
                                        <div class="line"></div>

                                    </div>

                                    <div class="details-inclusions">
                                        <?php
                                        $parts=explode("\n", $cruise->itinerary->include_meal);
                                        ?>
                                        @foreach($parts as $part)
                                            @svg('assets/check-mark.svg') {{ $part }} <br>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($cruise->itinerary->include_service)
                                <div class="inclusions-item">
                                    <div class="title-inclusions">
                                        <label>@svg('assets/services.svg') Service</label>
                                        <div class="line"></div>

                                    </div>

                                    <div class="details-inclusions">
                                        <?php
                                        $parts=explode("\n", $cruise->itinerary->include_service);
                                        ?>
                                        @foreach($parts as $part)
                                            @svg('assets/check-mark.svg') {{ $part }} <br>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($cruise->itinerary->include_excursions)
                                <div class="inclusions-item">
                                    <div class="title-inclusions">
                                        <label>@svg('assets/excursions.svg') Excursions</label>
                                        <div class="line"></div>

                                    </div>

                                    <div class="details-inclusions">
                                        <?php
                                        $parts=explode("\n", $cruise->itinerary->include_excursions);
                                        ?>
                                        @foreach($parts as $part)
                                            @svg('assets/check-mark.svg') {{ $part }} <br>
                                        @endforeach
                                    </div>
                                </div>

                            @endif

                            @if($cruise->itinerary->not_include)
                                <div class="inclusions-item">
                                    <div class="title-inclusions">
                                        <label>@svg('assets/minus-circle.svg') Price does not include</label>
                                        <div class="line"></div>
                                    </div>
                                    <div class="details-inclusions">
                                        <?php
                                        $parts=explode("\n", $cruise->itinerary->not_include);
                                        ?>
                                        @foreach($parts as $part)
                                            @svg('assets/red-x.svg') {{ $part }} <br>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>

@endif
                @endif


            @if(count($cruise->departures->where("date",">",now())))

                <div id="prices" class="price-section">
                    <div class="price-header">
                        <div class="title-row">
                            <div class="column label">Prices</div>
                            @if($cruise->departures->where("date",">",now())->max("date")->month != now()->month || $cruise->departures->where("date",">",now())->max("date")->year != now()->year)
                                <div class="column navigation">
                                <span class="button link previous-month"
                                      onclick="$('.price-picker').monthpicker('previousMonth',this)">@svg('assets/arrow-previous.svg','arrow_previous')<span
                                            class="show-m">prev</span></span>

{{--                                    ///////////////////////////////--}}
                                    <div class="input-field prefix sufix">
                                        <div class="arrow down sufix"></div>
                                        <div class="prefix">@svg('assets/date.svg')</div>
                                        <input name="month" type="hidden">
                                        <input data-events="{{json_encode($cruise->departures)}}"
                                               class="prices price-picker month-picker" readonly
                                               data-start-year="{{$cruise->departures->where("date",">",now())->min("date")->year}}"
                                               data-final-year="{{$cruise->departures->where("date",">",now())->max("date")->year}}"
                                               value="{{ $firstMonth }}"
                                               id="price-monthpicker"/>
                                    </div>

{{--                                    ///////////////////////////////////////////////--}}
                                    <span class="button link next-month"
                                            onclick="$('.price-picker').monthpicker('nextMonth',this)"><span class="show-m">next</span>@svg('assets/arrow-next.svg','arrow_next' )</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <?php
                    $foundActive=false;
                    $firstMonthPrice=$cruise->departures[0]->date->month;
                    ?>

                    @foreach($cruise->departures as $dep)
                        @if($dep->date->month != $firstMonthPrice)
                            @php
                                $foundActive=false;
                                $firstMonthPrice = $dep->date->month;
                            @endphp
                        @endif

                        <div data-date="{{$dep->date->format("Y-m")}}" class="expendable {{  $dep->date->format('m Y')==$firstMonth ? '' : 'hide' }} @if(!$foundActive) active <?php $foundActive=true; ?> @endif prices-date price-list-item date-{{$dep->date->format("Y-m")}}">
                            <div class="title" onclick="UI.expand(this)">
                                <div class="departure">
                                    <div class="departure-date">
                                        <label class="day">{{$dep->date->format('d')}}</label>
                                        <label class="month-year">{{$dep->date->format('M Y')}}</label>
{{--                                        <div class="amount {{ $dep->open==0 ? 'full' : 'avaliable' }}">{{ $dep->open==0 ? 'FULL' : 'AVALIABLE' }}</div>--}}
                                    </div>
                                    @if($dep->prices->max("popust") > 0)
{{--                                        brojac služi da se ne prikaže na stranici dva puta ako postoje kabine s istom cijenom koje su na popustu--}}
                                        <?php $brojac=0?>
                                        @foreach($dep->prices as $price)
                                            @if($price->real_price == $dep->prices->min('real_price') && $brojac==0)
                                                <?php $brojac=1?>
                                                <div class="departure-price">
                                                    <?= '<span class="price-discount-container">'."<span>from " . '<span class="discount-price">' . show_currency_price($price->price, "striketrough", "EUR") . ' <span class="discount-line"></span> <span class="discount-percent">-'. (int)$price->popust .'%</span></span>' . show_currency_price($price->real_price, null, "EUR") . "</span></span>"?>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="departure-price"><?=$dep->open == 0 ? '<span class="full-price show-xl">from ' . show_currency_price($dep->prices->min("real_price"), null, "EUR") . '</span><span><span class="full">FULL</span></span>' : "<span>from " . show_currency_price($dep->prices->min("real_price"), null, "EUR") . "</span><span class='show-xl'></span>"?></div>
                                    @endif
{{--                                    <div class="departure-price">price</div>--}}
                                </div>
                                @svg('assets/choose-month-arrow.svg','expand')
                            </div>

                            <div class="expand-cabin">

                                <div class="cabin-subtitle">@svg('assets/green-pearson.svg') Choose your preferred cabin and number of travelers</div>

                                <form action="{{action('BookingController@step2')}}" onsubmit="return UI.checkPeople()" method="POST">
                                    @csrf
                                    @php
                                    $zadnjaKabina=0;
                                    @endphp
                                    @foreach($dep->prices as $price)

                                        @if($price->id != $zadnjaKabina)
                                        <div class="cabin">
                                            @if(isset($price->room_type->image->webps->thumbnail_320))
                                            <div class="cabin-image">
{{--                                                <img src="https://www.mycroatiacruise.com/storage/ships/MS_Ambassador_thumb_320.webp">--}}
                                                <img src="{{ $price->room_type->image->webps->thumbnail_320 }}" alt="">
                                            </div>
                                            @endif

                                            <div class="cabin-details">
                                                <div class="cabin-title">{{ $price->room_type->name }}</div>
                                                <div class="cabin-people">{{ $price->room_type->beds == 1 ? "1 person" : "2 people" }}</div>
                                                <div class="cabin-bed">{{ $price->room_type->beds == 1 ? "Single bed" : "Double bed" }}</div>
                                                <div class="cabin-avaliable {{ $price->open==0 ? 'full' : '' }}">{{ $price->open==0 ? 'FULL' : '' }}</div>
                                            </div>

                                            <div class="cabin-price">
                                                <div class="price">{!! show_currency_price($price->real_price, "striketrough", "EUR") !!} per Person</div>
                                                <div class="discount">
                                                    <div class="discount-price {{ $price->real_price==$price->price ? 'hide' : '' }}">
                                                        {!! show_currency_price($price->price, null, "EUR") !!}
                                                    </div>
                                                    <div class="discount-percent {{ $price->real_price==$price->price ? 'hide' : '' }}">
                                                        -{{ (int)$price->popust }}%
                                                    </div>
                                                </div>
                                                <div class="number-people">
                                                    <div class="input-container">

                                                        <select class="select-people" name="number[{{ $price->id }}]">
                                                            <option data-text=" " value="0">0</option>
                                                            @for($i=0;$i<10;$i++)
                                                                <option data-text=" " value="{{$i+1}}">{{$i+1}}</option>
                                                            @endfor
                                                        </select>


                                                        <div class="arrow-container">
                                                            @svg('assets/choose-month-arrow.svg')
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @php
                                        $zadnjaKabina=$price->id;
                                        @endphp

                                    @endforeach

{{--                                    <div class="flexible-link">--}}
{{--                                        <div class="flexible-icon">@svg('assets/star.svg')</div>--}}
{{--                                        <a href="#" class="flexible-booking-link"><span>Flexible booking conditions</span></a>--}}
{{--                                    </div>--}}

                                    <div class="enquire">

                                        <div>
                                            <a href="#" class="payment-link">@svg('assets/payment-condition.svg')<span>View our payment conditions</span></a>
                                            | <a href="#" class="supplement-link">Supplements and reductions</a>
                                        </div>

                                        <button type="submit" class="button primary">ENQUIRE NOW</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="ship" class="ship-section">
                    <div class="ship-header">
                        <div class="blue-background"></div>
                        <div class="title-ship"><label>About {{$cruise->ship->name}} </label> @svg('assets/boat-yallow.svg')</div>

                        <div class="ship-specifications">
                            @if($cruise->ship->build)
                                <div class="specification">
                                    <div class="title-specification">Build</div>
                                    <div class="value">{{ $cruise->ship->build }}</div>
                                </div>
                            @endif

                            @if($cruise->ship->length)
                                <div class="specification">
                                    <div class="title-specification">Length</div>
                                    <div class="value">{{ $cruise->ship->length }} m</div>
                                </div>
                            @endif

                            @if($cruise->ship->width)
                                <div class="specification">
                                    <div class="title-specification">Beam</div>
                                    <div class="value">{{ $cruise->ship->width }} m</div>
                                </div>
                            @endif

                            @if($cruise->ship->speed)
                                <div class="specification">
                                    <div class="title-specification">Crusing speed</div>
                                    <div class="value">{{ $cruise->ship->speed }} kn</div>
                                </div>
                            @endif

                            @if($cruise->ship->cabins_quantity)
                                <div class="specification">
                                    <div class="title-specification">Cabins</div>
                                    <div class="value">{{ $cruise->ship->cabins_quantity }}</div>
                                </div>
                            @endif

                            @if($cruise->ship->capacity)
                                <div class="specification">
                                    <div class="title-specification">Capacity</div>
                                    <div class="value">{{ $cruise->ship->capacity }} pax</div>
                                </div>
                            @endif

                        </div>
                        <div class="ship-link-info"><a href="../small-ships-cruise-croatia/{{ $cruise->ship->slug }}">More about {{ $cruise->ship->name }}</a></div>
                    </div>



                </div>
            @endif
            </div>
        </div>

        <div id="gallery" class="section-gallery">

            <div class="slider-wrapper">
                <div id="gallery_slider" class="row slider">
                    @webp
                    <a
                        data-lightbox="{{$cruise->ship->name}}"
                        href="{{$cruise->ship->header_image->webps->url}}"
                        class="column xs6 s4 l6 xl4 hide ">
                    </a>
                    @else
                        <a
                            data-lightbox="{{$cruise->ship->name}}"
                            href="{{$cruise->ship->header_image->url}}"
                            class="column xs6 s4 l6 xl4 hide ">

                        </a>
                        @endwebp
                        @foreach($cruise->ship->images as $image)
                            <div class="slide-item">
                                @webp
                                <a
                                    data-lightbox="{{$cruise->ship->name}}"
                                    href="{{$image->webps->url}}"
                                    class="column xs6 s4 l6 xl4 ">
                                    <img src="{{$image->webps->thumbnail_768}}" alt="{{$image->alt}}"/>

                                </a>
                                @else
                                    <a
                                        data-lightbox="{{$cruise->ship->name}}"
                                        href="{{$image->url}}"
                                        class="column xs6 s4 l6 xl4">
                                    </a>
                                    @endwebp
                            </div>
                        @endforeach
                </div>
            </div>


        </div>

        <div class="inquiry-modal">
            <div class="inquiry-header">
                <div class="title">
                    <p>Book inquiry</p>
                </div>
                <div class="close-container">
                    @svg('assets/close.svg', 'close-button')
                </div>
            </div>
            <form class="row" id="cruise-booking-form">
                @csrf
                {!!  GoogleReCaptchaV3::renderField('contact_recaptcha','contact_us') !!}
                @if($private==1)
                    <input type="hidden" name="subject" id="subject"
                           value="{{$cruise->ship->name}} Private Charter"/>
                @elseif(!$isGulet)
                    <input type="hidden" name="subject" id="subject"
                           value="Cruise from {{$cruise->start->name}} to {{$cruise->finish->name}} with {{$cruise->ship->name}}"/>
                @else
                    <input type="hidden" name="subject" id="subject"
                           value="{{$cruise->ship->name}} Gulet Cruise"/>
                @endif
                <div class="input-container column xs12">
                    <div class="input-label">Your name*</div>
                    <label for="name"></label>
                    <input type="text" name="name" id="name" placeholder="ex. John Smith" value=""/>
                    <p class="error-message">Please fill out your name</p>
                </div>
                <input type="hidden" name="slug" value="{{ $cruise->slug }}"/>

                <div class="input-container column xs12">
                    <div class="input-label">Your country</div>
                    <label for="country"></label>
                    <select name="country" id="country">
                        <option data-text=" " value="">Select...</option>
                        @foreach($countries as $country)
                            <option data-text=" " value="{{ $country->name }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <p class="error-message">Please fill out your country</p>
                </div>
                <div class="input-container column xs12 m6">
                    <div class="input-label">Your phone</div>
                    <label for="phone"></label>
                    <input type="tel" name="phone" id="phone" placeholder="ex. +3859876543211" value=""/>
                    <p class="error-message">Please fill out your telephone number</p>
                </div>
                <div class="input-container column xs12 m6">
                    <div class="input-label">Your e-mail*</div>
                    <label for="email"></label>
                    <input type="email" name="email" id="email" placeholder="ex. john.smith@gmail.com" value=""/>
                    <p class="error-message">Please fill out your email correctly</p>
                </div>
                <div class="input-container column xs12 m6">
                    <div class="input-label">Number of people*</div>
                    <label for="pax"></label>
                    <input type="number" min="1" name="pax" id="pax" placeholder="ex. 2" value=""/>
                    <div class="arrow-container">
                        @svg('assets/arrow_up.svg', 'arrowUp')
                        @svg('assets/arrow_down.svg', 'arrowDown')
                    </div>
                    <p class="error-message">Please fill out the number of people going</p>
                </div>
                <div class="input-container column xs12 m6">
                    <div class="input-label">Departure Date*</div>
                    <label for="date"></label>
                    <input id="dep_date" data-toggle="datepicker" name="dep_date" autocomplete="off" readonly>
                    <p class="error-message">Please fill out the departure date</p>
                </div>
                <div class="input-container column xs12">
                    <div class="input-label">Your message</div>
                    <label for="message"></label>
                    <textarea rows="6" name="message" id="message"></textarea>
                    <p class="error-message">Please fill out your inquiry</p>
                    <div class="required-fields">* Required fields</div>
                </div>
                <div class="column xs12">
                    <a onclick="UI.sendMail(); ga('send',{hitType: 'event', eventCategory: 'Send Inquiry', eventAction: 'click'});" class="tag-manager-inquiry button primary">BOOK INQUIRY</a>
                </div>
            </form>
            <div class="modal-overlay">
                <img src="/assets/loading.gif" alt="loading" />
            </div>
        </div>

        <div class="payment-conditions-modal">
            <div class="pcm-header">
                <div class="title">
                    <h2>Payment Conditions</h2>
                </div>
                <div class="pcm-close-button">
                    @svg('/assets/close.svg')
                </div>
            </div>
            <div class="pcm-content">
                <div class="pcm-overflow-container">
                    @if($cruise->main_excursion->partner_id == 1)
                        @lang('cruise.payment.elite')
                    @elseif($cruise->main_excursion->partner_id == 2)
                        @lang('cruise.payment.gulliver')
                    @elseif($cruise->main_excursion->partner_id == 3)
                        @lang('cruise.payment.ambassador')
                    @elseif($cruise->main_excursion->partner_id == 4)
                        @lang('cruise.payment.atlas')
                    @elseif($cruise->main_excursion->partner_id == 5)
                        @lang('cruise.payment.zantium')
                    @elseif($cruise->main_excursion->partner_id == 6)
                        @lang('cruise.payment.katarina')
                    @elseif($cruise->main_excursion->partner_id == 16)
                        @lang('cruise.payment.roko-vukovic')
                    @elseif($cruise->main_excursion->partner_id == 27)
                        @lang('cruise.payment.as')
                    @endif
                </div>
            </div>
        </div>

        <div class="supplement-modal">
            <div class="pcm-header">
                <div class="title">
                    <h2>Supplements and reductions</h2>
                </div>
                <div class="pcm-close-button">
                    @svg('/assets/close.svg')
                </div>
            </div>
            <div class="pcm-content">
                <div class="pcm-overflow-container">
                    {{--                    @foreach($cruise->supplements as $supplement)--}}
                    {{--                        <div class='text'>--}}
                    {{--                            <p>--}}
                    {{--                            <ul>--}}
                    {{--                                <li>{{ $supplement->name }}: {{ round($supplement->price) }}{{$supplement->price_type==2 ? "%" : "€"}}</li>--}}
                    {{--                            </ul>--}}
                    {{--                            </p>--}}
                    {{--                        </div>--}}
                    {{--                    @endforeach--}}

                    @if($cruise->ship->id == 13)
                        @lang('cruise.supplement.splendid')
                    @elseif($cruise->main_excursion->partner_id == 1)
                        @lang('cruise.supplement.elite')
                    @elseif($cruise->main_excursion->partner_id == 2)
                        @lang('cruise.supplement.gulliver')
                    @elseif($cruise->main_excursion->partner_id == 3)
                        @lang('cruise.supplement.ambassador')
                    @elseif($cruise->main_excursion->partner_id == 4)
                        @lang('cruise.supplement.atlas')
                    @elseif($cruise->main_excursion->partner_id == 5)
                        @lang('cruise.supplement.zantium')
                    @elseif($cruise->main_excursion->partner_id == 6)
                        @lang('cruise.supplement.katarina')
                    @elseif($cruise->main_excursion->partner_id == 16)
                        @lang('cruise.supplement.roko-vukovic')
                    @elseif($cruise->main_excursion->partner_id == 27)
                        @lang('cruise.supplement.as')
                    @endif
                </div>
            </div>
        </div>

        <div class="flexible-booking-modal">
            <div class="pcm-header">
                <div class="title">
                    <h2>Flexible Booking Conditions</h2>
                </div>
                <div class="pcm-close-button">
                    @svg('/assets/close.svg')
                </div>
            </div>
            <div class="pcm-content">
                <div class="pcm-overflow-container">

                    @lang('cruise.flexible-booking-conditions')

                </div>
            </div>
        </div>
    </div>

    @include("partials.slider",["slider_title"=>"SIMILAR CRUISES"])
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")
    <script>
        var $sendUrl = "{!! route('cruise.sendMail') !!}";
        var $form = "#cruise-booking-form";
        document.addEventListener('DOMContentLoaded', () => UI.cruiseInit()); // (2)

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({
            'event': 'view_item',
            'ecommerce': {
                'items': [
                    {
                        'item_id': '{{$cruise->id}}',
                        'item_name': '{{$cruise->ship->name.': '.$cruise->start->name.' to '.$cruise->finish->name.' Cruise '.$cruise->year}}',
                        'price_from': {{round($cruise->min_price->real_price)}}, // tip: number
                        'currency': 'EUR',
                        'item_category': '{{$cruise->category->name}}',
                        'partner': '{{$cruise->main_excursion->partner_id}}',
                    }
                ]
            }
        });

    </script>

@endsection
