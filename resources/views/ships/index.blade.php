@extends('layouts.master')
@section('content')
    <div class="ships-container">
        <div class="header section">

            <div class="header-overlay"></div>
            <div class="header-content">
                <div class="title">
                    <div class="small">Cruise with a style</div>
                    <h1>The Best Small Cruise Ships on the Adriatic</h1>
                </div>
                <div class="text-container">
                    <div class="line"></div>
                    <div class="text">With a fleet of more than 60 ships in different categories, the cruise line caters
                        to all ages and budgets. Our mission is to give travelers the chance to explore the stunning
                        natural environment and picturesque, charming Mediterranean towns while hopping from one island
                        to another.
                    </div>
                </div>
            </div>
        </div>
        <div class="ships-wrapper section">
            <nav class="sticky sticky-desktop">
                <ul>
                    @foreach($filters as $filter=>$value)
                        <li><a data-filter-type="{{$value}}" {{($loop->index == 0)?'class=active':""}}>{{$filter}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="border-container">
                    <div class="border"></div>
                </div>
            </nav>
            <nav class="sticky sticky-mobile">
                <div class="dropdown item">
                    <div class="icon_prefix dropdown-trigger" href="">
                        <span>Ship category</span>
                        <i class="arrow down"></i>
                    </div>

                    <div class="dropdown-content contact-dropdown left" tabindex="-1">
                        <ul>
                            @foreach($filters as $filter=>$value)
                                <li><a data-filter-type="{{$value}}" {{($loop->index == 0)?'class=active':""}}>{{$filter}}</a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

                <div class="filter-ship-category-mobile">

                </div>
{{--                <ul>--}}
{{--                    @foreach($filters as $filter=>$value)--}}
{{--                        <li><a data-filter-type="{{$value}}" {{($loop->index == 0)?'class=active':""}}>{{$filter}}</a>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
                <div class="border-container">
                    <div class="border"></div>
                </div>
            </nav>
            <div class="ship-search-container">
                <label for="search-input"></label>
                <input type="text" name="search" id="search-input" placeholder="Search ALL Ships"/>
                @svg('/assets/search.svg', 'search-icon')
            </div>
            <div class="results">
                <div class="cards">
                    <div class="row ships_container">
                        @foreach($ships as $ship)
                            <div data-filter="{{$ship->ch_ship_category_id}}" data-name="{{strtolower($ship->name)}}"
                                 class="card ship column order-{{$loop->index}} xs12 m6 l4 xl4 xxl3">
                                <a class="card-link"
                                   href="{{route("ships.show","$ship->slug")}}">
                                    <div class="card-header">

                                        @webp
                                        <picture>
                                            <source media="(min-width: 752px)"
                                                    srcset="{{$ship->header_image->webps->thumbnail_620}}" type="image/webp">
                                            <source media="(min-width: 620px)"
                                                    srcset="{{$ship->header_image->webps->thumbnail_768}}" type="image/webp">
                                            <source media="(min-width: 375px)"
                                                    srcset="{{$ship->header_image->webps->thumbnail_620}}" type="image/webp">
                                            <source media="(min-width: 320px)"
                                                    srcset="{{$ship->header_image->webps->thumbnail_375}}" type="image/webp">

                                            <img src="{{$ship->header_image->webps->url}}" alt="{{$ship->name}}"
                                                 title="{{$ship->header_image->title}}"
                                                 class="cover-img">
                                        </picture>
                                        @else
                                            <picture>
                                                <source media="(min-width: 752px)"
                                                        srcset="{{$ship->header_image->thumbnail_620}}" type="image/webp">
                                                <source media="(min-width: 620px)"
                                                        srcset="{{$ship->header_image->thumbnail_768}}" type="image/webp">
                                                <source media="(min-width: 375px)"
                                                        srcset="{{$ship->header_image->thumbnail_620}}" type="image/webp">
                                                <source media="(min-width: 320px)"
                                                        srcset="{{$ship->header_image->thumbnail_375}}" type="image/webp">

                                                <img src="{{$ship->header_image->url}}" alt="{{$ship->name}}"
                                                     title="{{$ship->header_image->title}}"
                                                     class="cover-img">
                                            </picture>
                                            @endwebp

                                        @if(false)
                                            <div class="tag {{$ship->tag_class}}">{{$ship->tag_name}}</div>
                                        @endif
                                        @if($ship->charter == 2)
                                            <div class="tag great-value">For private charters</div>
                                        @endif
                                    </div>
                                    <div class="card-content">
                                        <div class="card-title">
                                            <div class="ship-name">
                                                {{$ship->name}}
                                            </div>
                                            <div class="ship-type">
                                                {{$ship->category->name}}
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <div class="ship-capacity">
                                            <div class="left-ship">
                                                @svg('/assets/icon-capacity.svg')
                                                <span>Capacity</span>
                                            </div>
                                            <div class="right-ship">{{($ship->capacity)?$ship->capacity.' persons':'N/A'}}</div>
                                        </div>
                                        <div class="line"></div>
                                        <div class="ship-accomodation">
                                            <div class="left-ship">
                                                @svg('/assets/icon-cabins.svg')
                                                <span>Acommodation</span>
                                            </div>
                                            <div class="right-ship">{{($ship->cabins_quantity)?$ship->cabins_quantity.' cabins':'N/A'}}</div>
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
        document.addEventListener('DOMContentLoaded', () =>    UI.shipsInit()); // (2)
    </script>

@endsection
