@extends('layouts/master')
@section('content')
    <div class="home-container">
        <div class="header section">
{{--            <div class="socials">--}}
{{--                <div class="social">--}}
{{--                    <a href="https://www.facebook.com/www.croatiaholidays.travel/" target="_blank" class="button icon icon-social">@svg('assets/facebook.svg')</a>--}}
{{--                </div>--}}
{{--                <div class="social">--}}
{{--                    <a href="https://www.instagram.com/croatiaholidays.travel/" target="_blank" class="button icon icon-social">@svg('assets/instagram.svg')</a>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="search-wrapper">
                <div class="left-home-box">
                    <div class="subtitle">
                        @lang('welcome.subtitle')
                    </div>
                    <h1 class="title-white">@lang('welcome.title-blue') <br>
                        <span class="title-white">@lang('welcome.title-white')</span>
                    </h1>

                    <div class="line"></div>
                    <div class="search-container">
                        <form id="main_search" action="{{route('cruises.index')}}">
                            <div class="input-field prefix sufix">
                                <div class="arrow down sufix"></div>
                                <div class="prefix">@svg('assets/date.svg')</div>
                                <input name="month" type="hidden">
                                <input type="text" value="{{isset($month)?$month->format("m Y"):""}}" readonly  placeholder="Choose month" data-start-year="{{$month->year}}"
                                       data-final-year="{{$month->year+1}}" data-events="{{json_encode($departures)}}"  class="show-m month-picker month-picker">
                                <input type="text" id="monthpicker-trigger" value="Choose month" readonly
                                       class="hide-m modal-trigger"  data-target="search"></div>
                            <div class="input-field">
                                <button class="button primary">@lang('welcome.search-button')</button>
                            </div>
                        </form>
                    </div>
                    <div class="special-offer-container">
                        <div class="special-bg"></div>
                        <div class="note-1 text-center">2025 SPECIAL OFFERS
                            SAVE up to 25%</div>
{{--                        <div class="special-title">Special Offers</div>--}}
                        <a class="button special-offer" href="{{ route('cruises.lmd') }}">check here</a>
                        <div class="note-2">SAVE up to 25%*</div>


                    </div>
                    <div class="note">
{{--                        <div class="icon">@svg('assets/asterisk.svg')</div>--}}
                        @if(date("Y-m-d") <= "2024-12-01")
                            <div class="text">*Black Friday extra 10% off on some departures!</div>
                        @else
                        <div class="text">@lang('welcome.note-text')</div>
                            @endif
                    </div>
                </div>
                @if($lmd > 0)

{{--                <div class="last-minute-home-box-container">--}}
{{--                    <div class="last-minute-home-box">--}}
{{--                        @svg('/assets/last-minute-background.svg', 'background-waves')--}}
{{--                        <div class="main-container">--}}
{{--                            <div class="title-container">--}}
{{--                                <div class="small-title">EARLY BOOKING DISCOUNT</div>--}}
{{--                                <div class="big-title">2022 CRUISES</div>--}}
{{--                            </div>--}}
{{--                            <div class="images">--}}
{{--                                @foreach($lmd_images as $lmd)--}}
{{--                                    @webp--}}
{{--                                        <img src="{{$lmd->header_image->webps->thumbnail_120}}" class="img {{($loop->index == 0)?'show-s':'show-m'}} {{($loop->index == 2)?'hide-l show-xl':''}}" alt="Early booking discount" />--}}
{{--                                    @else--}}
{{--                                        <img src="{{$lmd->header_image->thumbnail_120}}" class="img {{($loop->index == 0)?'show-s':'show-m'}} {{($loop->index == 2)?'hide-l show-xl':''}}" alt="Early booking discount" />--}}
{{--                                    @endwebp--}}

{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                       </div>--}}
{{--                        <a class="lmd_button hide-l" href="{{route('cruises.lmd')}}">VIEW</a>--}}
{{--                        <a class="lmd_button show-l" href="{{route('cruises.lmd')}}">VIEW CRUISES</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                @endif
            </div>
        </div>

        <div class="mobile-search">
            <div class="search-container">
                <form id="main_search" action="{{route('cruises.index')}}">
                    <div class="input-field prefix sufix">
                        <div class="arrow down sufix"></div>
                        <div class="prefix">@svg('assets/date.svg')</div>
                        <input name="month" type="hidden">
                        <input type="text" readonly value="{{isset($month)?$month->format("m Y"):""}}" placeholder="Choose month" data-start-year="{{$month->year}}"
                               data-final-year="{{$month->year}}" data-events="{{json_encode($departures)}}"  class="show-m month-picker month-picker">
                        <input type="text" id="monthpicker-trigger" value="Choose month" readonly
                               class="hide-m modal-trigger"  data-target="search"></div>
                    <div class="input-field">
                        <button class="button primary">@lang('welcome.search-button')</button>
                    </div>
                </form>
            </div>
            <div class="special-offer-container">
{{--                <div class="special-bg"></div>--}}
{{--                <div class="special-offer-icon">@svg('/assets/star-yallow-circle.svg')</div>--}}
                <div class="note-1">2025 SPECIAL OFFERS
                    SAVE up to 25%</div>
{{--                <div class="special-offer-title">Enjoy Special Booking Discounts 2024</div>--}}
                <a class="button special-offer" href="{{ route('cruises.lmd') }}">check here</a>
                <div class="note-2">SAVE up to 25%*</div>
                @if(date("Y-m-d") <= "2024-12-01")
                    <div class="note-2"><span>*Black Friday extra 10% off on some departures!</span></div>
                @endif

            </div>
        </div>

        @webp
            <div class="section parallax-window subsection cruises" data-position-x="center" data-speed="0.6"
                 data-parallax="scroll" data-image-src="/images/home-cruises-background.webp" style="background-image: url('/images/home-cruises-background.webp'); background-size: cover; background-position: center center;")>
        @else
            <div class="section parallax-window subsection cruises" data-position-x="center" data-speed="0.6"
                         data-parallax="scroll" data-image-src="/images/home-cruises-background.jpg">
        @endwebp
            <div class="cover column">
                @webp
                    <picture>
                        <source media="(min-width: 1200px)" srcset="/images/cruises.webp">
                        <source media="(min-width: 752px)" srcset="/images/cruises_vertical.webp">
                        <source media="(min-width: 752px)" srcset="/images/cruises_vertical.webp">
                        <source media="(min-width: 504px)" srcset="/images/cruises.webp">
                        <img class="img" src="/images/cruises_vertical.webp" alt="Adriatic Cruises Croatia">
                    </picture>
                @else
                    <picture>
                        <source media="(min-width: 1200px)" srcset="/images/cruises.png">
                        <source media="(min-width: 752px)" srcset="/images/cruises_vertical.png">
                        <source media="(min-width: 752px)" srcset="/images/cruises_vertical.png">
                        <source media="(min-width: 504px)" srcset="/images/cruises.png">
                        <img class="img" src="/images/cruises_vertical.png" alt="Adriatic Cruises Croatia">
                    </picture>
                @endwebp

            </div>
            <div class="content column">
                <div class="title">
                    <span class="blue">@lang('welcome.cruises-blue-title')</span><br>@lang('welcome.cruises-title')
                </div>
                <div class="line"></div>
                <div class="text">@lang('welcome.cruises-text')
                </div>
                <a href="{{route('cruises.index')}}" class="button primary">@lang('welcome.cruises-link')</a>
            </div>
        </div>
        <div class="section subsection ships">
            <div class="cover column">
                @webp
                    <picture>
                        <source media="(min-width: 1200px)" srcset="/images/ships.webp">
                        <source media="(min-width: 752px)" srcset="/images/ships_vertical.webp">
                        <source media="(min-width: 752px)" srcset="/images/ships_vertical.webp">
                        <source media="(min-width: 504px)" srcset="/images/ships.webp">
                        <img class="img" src="/images/ships_vertical.webp" alt="Adriatic Small Ships Cruise Croatia">
                    </picture>
                @else
                    <picture>
                        <source media="(min-width: 1200px)" srcset="/images/ships.png">
                        <source media="(min-width: 752px)" srcset="/images/ships_vertical.png">
                        <source media="(min-width: 752px)" srcset="/images/ships_vertical.png">
                        <source media="(min-width: 504px)" srcset="/images/ships.png">
                        <img class="img" src="/images/ships_vertical.png" alt="Adriatic Small Ships Cruise Croatia">
                    </picture>
                @endwebp
            </div>
            <div class="content column">
                <div class="title">
                    @lang('welcome.ships-title')<br><span class="blue">@lang('welcome.ships-blue-title')</span>
                </div>
                <div class="line"></div>
                <div class="text">@lang('welcome.ships-text')</div>
                <a href="{{route('ships.index')}}" class="button primary">@lang('welcome.ships-link')</a>
            </div>
        </div>
        <div class="section subsection places ">
            <div class="cover column">
                @webp
                    <picture>
                        <source media="(min-width: 1200px)" srcset="/images/places.webp">
                        <source media="(min-width: 752px)" srcset="/images/places_vertical.webp">
                        <source media="(min-width: 752px)" srcset="/images/places_vertical.webp">
                        <source media="(min-width: 504px)" srcset="/images/places.webp">
                        <img class="img" src="/images/places_vertical.webp" alt="Adriatic Small Ships Cruise Croatia">
                    </picture>
                @else
                    <picture>
                        <source media="(min-width: 1200px)" srcset="/images/places.png">
                        <source media="(min-width: 752px)" srcset="/images/places_vertical.png">
                        <source media="(min-width: 752px)" srcset="/images/places_vertical.png">
                        <source media="(min-width: 504px)" srcset="/images/places.png">
                        <img class="img" src="/images/places_vertical.png" alt="Adriatic Small Ships Cruise Croatia">
                    </picture>
                @endwebp

            </div>
            <div class="content column">
                <div class="title">
                    @lang('welcome.destinations-title-before-blue')<span class="blue">@lang('welcome.destinations-blue-title')<br>@lang('welcome.destinations-title-after-blue')</span>
                </div>
                <div class="line"></div>
                <div class="text">@lang('welcome.destinations-text')</div>
                <a href="{{route('destinations.index')}}" class="button primary">@lang('welcome.destinations-link')</a>
            </div>
        </div>

        @include("partials.slider",["main_title"=>"FEATURED"])
        @include("partials.summer")
        @include("partials.blog")
        @include("partials.contact")
        <script>
            document.addEventListener('DOMContentLoaded', () =>    UI.homeInit()); // (2)





        </script>
    </div>

@endsection
