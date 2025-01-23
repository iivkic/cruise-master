@extends('layouts.master')
@section('content')
    <div class="cruises-container">
        <div id="destinations-modal" class="modal filters-modal photo-select-modal">
            <div class="header">
                <a class="button hide-l link" onclick="UI.hideModalFilters('destinations-modal')">@svg('/assets/back.svg','
                    single modal-close')</a>
                <div class="input-field search-field"><input class="search-input" name="destination_search" placeholder="Search destination" id="destination_search"/></div>
                <a onclick="UI.hideFilters()" class="button link">@svg('/assets/close.svg','filter-close modal-close')</a>
            </div>
            <div class="content">
                <div class="options-wrapper row">
                    @foreach($destinations as $destination)
                        <label class="column xs12 checkbox-photo-label destination-item">
                            <input value="{{$destination->id}}" type="checkbox" name="destinations">
                            <span class="checkmark"></span>
                            <div class="photo">
                                @webp
                                <picture>
                                    <source media="(min-width: 180px)" srcset="{{$destination->header_image->webps->thumbnail_120}}" type="image/webp">
                                    <img src="{{$destination->header_image->webps->url}}" alt="{{$destination->header_image->alt}} Croatia Cruise" title="{{$destination->header_image->title}}"
                                         class="cover-img">
                                </picture>
                                @else
                                    <picture>
                                        <source media="(min-width: 180px)" srcset="{{$destination->header_image->thumbnail_120}}">
                                        <img src="{{$destination->header_image->url}}" alt="{{$destination->header_image->alt}} Croatia Cruise" title="{{$destination->name}}"
                                             class="cover-img">
                                    </picture>
                                    @endwebp
                            </div>
                            <span class="title">{{$destination->name}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="footer">
                <div class="row">
                    <a onclick="UI.clearModalFilters('destination-item')" class="button secondary dark-bg column xs6 ">CLEAR ALL</a>

                    <a onclick="UI.applyModalFilters('destinations-modal')"
                       class="button primary dark-bg hide-l column xs6 ">APPLY</a>
                    <a onclick="UI.applyFilters()" class="button primary show-l column xs6">APPLY</a>
                </div>
            </div>
        </div>
        <div id="ships-modal" class="modal filters-modal photo-select-modal">
            <div class="header">
                <a class="button hide-l link" onclick="UI.hideModalFilters('ships-modal')">@svg('/assets/back.svg','single
                    modal-close')</a>
{{--                <div class="title">Ships</div>--}}
                <div class="input-field search-field"><input class="search-input" name="ship_search" placeholder="Ship category" id="ship_search"/></div>
                <a onclick="UI.hideFilters()" class="button link">@svg('/assets/close.svg','filter-close modal-close')</a>
            </div>
            <div class="content">
                <div class="options-wrapper row">
                    @foreach($categories as $category)
                        <label class="column xs12 checkbox-photo-label ship-item">
                            <input value="{{$category->id}}" type="checkbox" name="ships">
                            <span class="checkmark"></span>
{{--                            <div class="photo">--}}
{{--                                @webp--}}
{{--                                <picture>--}}
{{--                                    <source media="(min-width: 180px)" srcset="{{$ship->header_image->webps->thumbnail_120}}" type="image/webp">--}}
{{--                                    <img src="{{$ship->header_image->webps->url}}" alt="{{$ship->header_image->alt}} Croatia Cruise" title="{{$ship->header_image->title}}"--}}
{{--                                         class="cover-img">--}}
{{--                                </picture>--}}
{{--                                @else--}}
{{--                                    <picture>--}}
{{--                                        <source media="(min-width: 180px)" srcset="{{$destination->header_image->thumbnail_120}}">--}}
{{--                                        <img src="{{$ship->header_image->url}}" alt="{{$ship->header_image->alt}} Croatia Cruise" title="{{$ship->name}}"--}}
{{--                                             class="cover-img">--}}
{{--                                    </picture>--}}
{{--                                    @endwebp--}}
{{--                            </div>--}}
                            <span class="title">{{$category->name}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="footer">
                <div class="row">
                    <a onclick="UI.clearModalFilters('ship-item')" class="button secondary dark-bg column xs6 ">CLEAR ALL</a>
                    <a onclick="UI.applyModalFilters('ships-modal')" class="button primary dark-bg hide-l column xs6 ">APPLY</a>
                    <a onclick="UI.applyFilters()" class="button primary dark-bg show-l column xs6 ">APPLY</a>
                </div>
            </div>
        </div>
        <div id="filter-modal" class="modal filters filters-modal main-filters-modal">
            <div class="header">
                @svg('assets/filter.svg','icon')
                <div class="title">Filter by</div>
                <a onclick="UI.hideFilters()" class="button close link">@svg('/assets/close.svg','hide-xl filter-close
                    modal-close')</a>
            </div>
            <div class="line show-l"></div>
            <div class="content">
                <div class="box">

                    <label>Price range (per person):</label>

                    <?=show_range_price(300, 3000, "EUR")?>
                    <div class="decoration"><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span><span>|</span>
                    </div>
                    <div class="amounts">
                        <span><input type="hidden" id="price_from" readonly
                                     style="border:0; color:#f6931f; font-weight:bold;"><span class="price_from"></span></span>
                        <span><input type="hidden" id="price_to" readonly
                                     style="border:0; color:#f6931f; font-weight:bold;"><span
                                    class="price_to"></span></span>
                    </div>
                </div>
                <div class="line"></div>
{{--                <div class="box">--}}
{{--                    <label><span>Duration:</span></label>--}}
{{--                    <div class="options-wrapper">--}}
{{--                        <label class="checkbox-label">0-5 days--}}
{{--                            <input value="0-5" type="checkbox" name="duration">--}}
{{--                            <span class="checkmark"></span>--}}
{{--                        </label>--}}

{{--                        <label class="checkbox-label">5 - 10 days--}}
{{--                            <input value="5-10" type="checkbox" name="duration">--}}
{{--                            <span class="checkmark"></span>--}}
{{--                        </label>--}}

{{--                        <label class="checkbox-label">10+--}}
{{--                            <input value="10" type="checkbox" name="duration">--}}
{{--                            <span class="checkmark"></span>--}}
{{--                        </label>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="line"></div>--}}
                <div class="box">
                    <label><span>Start port</span></label>
                    <div class="options-wrapper">
                        <label class="checkbox-label radio">Any port
                            <input data-label="Start" value="0" type="radio" name="start" checked="checked">
                            <span class="checkmark"></span>
                        </label>

                        @foreach($starting_ports as $sp)
                            <label class="checkbox-label radio">{{$sp->name}}
                                <input data-label="Start" value="{{$sp->id}}" type="radio" name="start">
                                <span class="checkmark"></span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="line"></div>
                <div class="box">
                    <label><span>Finish port</span></label>
                    <div class="options-wrapper">
                        <label class="checkbox-label radio radio">Any port
                            <input data-label="Finish" value="0" type="radio" name="finish" checked="checked">
                            <span class="checkmark"></span>
                        </label>

                        @foreach($ending_ports as $ep)
                            <label class="checkbox-label radio">{{$ep->name}}
                                <input data-label="Finish" value="{{$ep->id}}" type="radio" name="finish">
                                <span class="checkmark"></span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="line both"></div>
                <div class="box destination-box">
                    <a class="destinations button link modal-trigger" onclick="UI.showModalFilters('destinations-modal')"
                    data-target="destinations-modal">
                    <div class="title">Search Destinations</div>
                    <span class="counter destinations-counter hide">0</span><span class="arrow right arrow-right"></span></a>
                </div>
                <div class="line both"></div>
                <div class="box ship-box last">
                        <a class="ships button link modal-trigger" onclick="UI.showModalFilters('ships-modal')"
                           data-target="ships-modal">
                            <div class="title">Ship Category</div>
                            <span class="counter ships-counter hide">0</span><span class="arrow right arrow-right"></span></a>
                </div>
                <div class="line both"></div>
                <input data-label="Recommended" value="0" type="hidden" name="recommended">
            </div>
            <div class="footer hide-l">
                <div class="row">
                    <a onclick="UI.resetFilters()" class="button secondary  column xs6">RESET</a>
                    <a onclick="UI.applyFilters()" class="button primary dark-bg column xs6 ">APPLY</a>
                </div>
            </div>
            <div class="help-modal show-l">
                <div class="help-icon">
                    @svg('/assets/help.svg')
                </div>
                <div class="help-text">
                    <p>Haven't found what you are looking for?</p>
                </div>
                <div class="help-links">
                    <p><a onclick="UI.resetFilters()">RESET YOUR FILTERS</a><a onclick="UI.loadPreviousFilters(true)">GO BACK TO PREVIOUS SEARCH</a><a onclick="UI.loadRecommendedFilter(true)">LOOK AT OUR RECOMMENDATIONS</a>
                </div>
            </div>
        </div>

        <div class="content">
            @if($lmd > 0)
                <div class="last-minute-hover-box">
                    <div class="title">Special Offer Discount 2025 Cruises</div>
                    <div class="lm-buttons">
                        <a href="{{route('cruises.lmd')}}" class="button secondary">VIEW</a>
                        @svg('assets/close.svg', 'close-hover-box')
                    </div>
                </div>
            @endif
                <h1 id="cruises_points">

                    @if(isset($_GET['start']) || isset($_GET['finish']))
                        @if(isset($_GET['start']) && isset($_GET['finish']))
                        Cruises from
                        {{$destinations->where('id', $_GET['start'])->first()->name}} to
                        {{ $destinations->where('id',$_GET['finish'])->first()->name }}
                        @else
                            @if(isset($_GET['start']) && !isset($_GET['finish']))
                                Cruises from
                                {{$destinations->where('id', $_GET['start'])->first()->name}}
                        @else
                                                    Cruises to
                        {{$destinations->where('id', $_GET['finish'])->first()->name}}
                        @endif
                        @endif

                        @else
                            All Cruises
                        @endif

                </h1>

            <div class="content-header row">
                <div class="results-number column show-l">We found <span class="number">{{$excursions->total()}}</span> cruises in <span>{{date_format($month, 'F Y')}}</span></div>
                <div class="line"></div>
                <div class="active-filters column hide-xl">
                    <button data-target="filter-modal" onclick="UI.showFilters('filter-modal')"
                         class="button primary filter-trigger hide-l">
                        @svg('assets/filter.svg')<span>filters</span><span class="filters-counter hide">0</span></button>
                    <div class="filter-list show-l">
                    </div>
                </div>
                <div class="actions column show-l">
                    <div class="label"><span><button onclick="UI.resetFilters()" disabled class="button link reset-filters">reset filters</button></span></div>
                    <div class="label"><span>switch view</span></div>

                    <div class="button icon icon-only {{session()->get("detailed_view",1)==1?"":"active"}}">
                        @svg('assets/general-view.svg','view-config card-view')
                    </div>
                    <div class="button icon icon-only {{session()->get("detailed_view",1)==1?"active":""}}">
                        @svg('assets/detail-view.svg','view-config detailed-view')

                    </div>
                </div>
{{--                <div class="reset show-l column">--}}
{{--                    <button onclick="UI.resetFilters()" disabled class="button link reset-filters">reset filters</button>--}}
{{--                </div>--}}
            </div>

            <div class="results">
                <div class="loading-overlay">
                    <div class="loading-message-container">
                        <div class="loading-message">
                            <img src="/assets/loading.gif" alt="loading gif" width="50" height="50" />
                            <div class="message">Please wait</div>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    @include("ajax.filter_cruise")
                </div>
            </div>
            <form action="{{route("booking.step1")}}" method="POST" class="priceForm">
                @csrf
                <input type="hidden" name="id" value=""/>
                <button class="hide"></button>
            </form>
        </div>

    </div>
    <div class="cruises-summer">
        @include("partials.summer")
    </div>
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.cruisesInit({!! json_encode($output_filters)!!})); // (2)
    </script>
@endsection
