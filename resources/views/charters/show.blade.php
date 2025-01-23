@extends('layouts.master')
@section('content')
    <div class="ship-container">
        <div class="header section">

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
                <div class="header-overlay"></div>
                <div class="header-content">
                    <div class="title">
                        <div class="small">{{ $ship->category->name }}</div>
                        <h1>{{ $ship->name }}</h1>
                    </div>
                </div>
        </div>
        <div class="content section">
            <div class="ship-right row">
                <div class="column xs12 explore-image show-s">

                    @webp
                    <picture>
                        <source media="(min-width: 1200px)"
                                srcset="{{$ship->header_image->url}}" type="image/webp">
                        <source media="(min-width: 768px)"
                                srcset="{{$ship->header_image->thumbnail_768}}" type="image/webp">
                        <source media="(min-width: 320px)"
                                srcset="{{$ship->header_image->thumbnail_320}}" type="image/webp">

                        <img src="/images/ship_artwork.webp" alt="explore adriatic with {{$ship->name}}"
                             title="{{$ship->header_image->title}}"
                             class="cover-img">
                        @else
                            <picture>
                                <source media="(min-width: 1200px)"
                                        srcset="{{$ship->header_image->url}}" type="image/webp">
                                <source media="(min-width: 768px)"
                                        srcset="{{$ship->header_image->thumbnail_768}}" type="image/webp">
                                <source media="(min-width: 320px)"
                                        srcset="{{$ship->header_image->thumbnail_320}}" type="image/webp">

                                <img src="/images/ship_artwork.png" alt="explore adriatic with {{$ship->name}}"
                                     title="{{$ship->header_image->title}}"
                                     class="cover-img">
                            </picture>
                            @endwebp

                </div>
                <div class="column xs12 explore-content show-s">
                    <div class="explore-title">
                        <span class="title-light-blue">Explore Adriatic</span><br>with {{$ship->name}}
                    </div>
                    @if($ship->charter == 1)
                        <a href="{{route('contact')}}?subject=Private%20charter%20inquiry%20-%20{{$ship->name}}" class="charter-button button">Send us your private <br> charter inquiry</a>
                    @else
                        <a href="{{route('contact')}}?subject=Private%20charter%20inquiry%20-%20{{$ship->name}}" class="button">ENQUIRE NOW</a>
                    @endif

                </div>
            </div>
            <div class="ship-left">
                @isset($ship->description)
                    <div class="ship-text">
                        <?php
                        $parts=explode("\n", $ship->description);
                        ?>
                        @foreach($parts as $p)
                            <p>{{$p}}</p>
                        @endforeach
                    </div>
                @endisset
                <div class="technical-specifications">
                    <?php $expanded=0; ?>

                    <div class="expand">
                        <div class="ship-spec-title" onclick="UI.expandDetails('specifications')">
                            <h5>SPECIFICATIONS</h5>
                            @svg('assets/choose-month-arrow.svg','expand')
                        </div>
                        <div class="ship-details {{$expanded==0?'active':''}}" id="specifications">
                            <?php $expanded=1; ?>
                            <p class="title-light-blue">General</p>

                            <table>
                                @if(isset($ship->length))
                                    <tr>
                                        <td class="t-name">Length</td>
                                        <td class="t-value">{{$ship->length}} meters</td>
                                    </tr>
                                @endif
                                @if(isset($ship->width))
                                    <tr>
                                        <td class="t-name">Beam</td>
                                        <td class="t-value">{{$ship->width}} meters</td>
                                    </tr>
                                @endif
                                @if(isset($ship->draft))
                                    <tr>
                                        <td class="t-name">Draft</td>
                                        <td class="t-value">{{$ship->draft}} meters</td>
                                    </tr>
                                @endif
                                @if(isset($ship->crew) && $ship->crew!="")
                                    <tr>
                                        <td class="t-name">Crew</td>
                                        <td class="t-value">
                                            <?php
                                            $parts=explode("\n", $ship->crew);
                                            ?>
                                            @foreach($parts as $p)
                                                <p>{{$p}}</p>
                                            @endforeach

                                        </td>
                                    </tr>
                                @endif
                                @if(isset($ship->build) && $ship->build!="")
                                    <tr>
                                        <td class="t-name">Built</td>
                                        <td class="t-value">{{$ship->build}}</td>
                                    </tr>
                                @endif
                                @if(isset($ship->refit))
                                    <tr>
                                        <td class="t-name">Refit</td>
                                        <td class="t-value">{{$ship->refit}}</td>
                                    </tr>
                                @endif
                                @if(isset($ship->max_speed))
                                    <tr>
                                        <td class="t-name">Max Speed</td>
                                        <td class="t-value">{{$ship->max_speed}} knots</td>
                                    </tr>
                                @endif
                                @if(isset($ship->speed))
                                    <tr>
                                        <td class="t-name">Cruising Speed</td>
                                        <td class="t-value">{{$ship->speed}} knots</td>
                                    </tr>
                                @endif
                                @if(isset($ship->engine) && $ship->engine!="")
                                    <tr>
                                        <td class="t-name">Engine</td>
                                        <td class="t-value">{{$ship->engine}}</td>
                                    </tr>
                                @endif

                            </table>

                            <p class="title-light-blue">Accommodation</p>

                            <table>
                                @if(isset($ship->capacity))
                                    <tr>
                                        <td class="t-name">Guests</td>
                                        <td class="t-value">{{$ship->capacity}}</td>
                                    </tr>
                                @endif
                                @if(isset($ship->cabins_quantity))
                                    <tr>
                                        <td class="t-name">Cabins</td>
                                        <td class="t-value">{{$ship->cabins_quantity}}</td>
                                    </tr>
                                @endif
                                @if(isset($ship->cabin_configuration) && $ship->cabin_configuration!="")
                                    <tr>
                                        <td class="t-name">Cabin Configuration</td>
                                        <td class="t-value">
                                                <?php
                                                $parts=explode("\n", $ship->cabin_configuration);
                                                ?>
                                            @foreach($parts as $p)
                                                <p>{{$p}}</p>
                                                @if($p=="")
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            </table>
                            <br>

                            @if(isset($ship->accommodation) && $ship->accommodation!="")
                                    <?php
                                    $parts=explode("\n", $ship->accommodation);
                                    ?>
                                @foreach($parts as $p)
                                    <p>{{$p}}</p>
                                @endforeach
                            @endif

                            <p class="title-light-blue">Amenities</p>

                            @if(isset($ship->equipment) && $ship->equipment!="")
                                    <?php
                                    $parts=explode("\n", $ship->equipment);
                                    ?>
                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach
                            @endif

                            <p class="title-light-blue">Watertoys</p>

                            @if(isset($ship->watertoys) && $ship->watertoys!="")
                                    <?php
                                    $parts=explode("\n", $ship->watertoys);
                                    ?>
                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach
                            @endif


                        </div>
                    </div>

                    @if(isset($ship->layout_image) && trim($ship->layout_image) != "")
                        <div class="expand">
                            <div class="ship-spec-title"  onclick="UI.expandDetails('layout')">
                                <h5>LAYOUT<h5>
                                @svg('assets/choose-month-arrow.svg','expand')
                            </div>
                            <div class="ship-details {{$expanded==0?'active':''}}" id="layout">
                                    <?php $expanded=1; ?>
                                @webp
                                <picture>

                                    <source media="(max-width: 375px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->webps->thumbnail_320}}" type="image/webp">
                                    <source media="(max-width: 620px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->webps->thumbnail_375}}" type="image/webp">
                                    <source media="(max-width: 768px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->webps->thumbnail_768}}" type="image/webp">
                                    <source media="(max-width: 1150px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->webps->thumbnail_1150}}" type="image/webp">

                                    <img id="charter-img" src="https://www.mycroatiacruise.com/{{$ship->layout_image->webps->url}}" alt="{{$ship->layout_image->alt}}" title="{{$ship->layout_image->title}}"
                                         class="cover-img">
                                </picture>
                                @else
                                    <picture>

                                        <source media="(max-width: 375px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->thumbnail_320}}">
                                        <source media="(max-width: 620px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->thumbnail_375}}">
                                        <source media="(max-width: 768px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->thumbnail_768}}">
                                        <source media="(max-width: 1150px)" srcset="https://www.mycroatiacruise.com/{{$ship->layout_image->thumbnail_1150}}">

                                        <img id="charter-img-jpg" src="https://www.mycroatiacruise.com/{{$ship->layout_image->thumbnail_768}}" alt="{{$ship->layout_image->alt}}" title="{{$ship->layout_image->title}}"
                                             class="cover-img">
                                    </picture>
                                    @endwebp

                                    <div class="img-overlay"></div>
                            </div>
                        </div>
                    @endif

                    <div  class="expand">
                        <div class="ship-spec-title" onclick="UI.expandDetails('price')">
                            <h5>PRICE</h5>
                            @svg('assets/choose-month-arrow.svg','expand')
                        </div>

                        <div class="ship-details {{$expanded==0?'active':''}}" id="price">
                            <?php $expanded=1; ?>

                            @if(isset($ship->price_extend) && $ship->price_extend!="")
                                    <?php
                                    $parts=explode("\n", $ship->price_extend);
                                    ?>
                                @foreach($parts as $p)
                                    <p class="title-light-blue">{{$p}}</p>
                                @endforeach
                            @endif
                            @if(isset($ship->price_details) && $ship->price_details!="")
                                    <?php
                                    $parts=explode("\n", $ship->price_details);
                                    ?>
                                @foreach($parts as $p)
                                    <p>{{$p}}</p>
                                @endforeach
                            @endif


                            @if(isset($ship->include) && $ship->include!="")
                                <p class="title-light-blue">Price includes:</p>

                                <?php
                                    $parts=explode("\n", $ship->include);
                                    ?>

                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach

                            @endif

                            @if(isset($ship->obligatory_supplements) && $ship->obligatory_supplements!="")
                                <p class="title-light-blue">Obligatory Supplements</p>

                                <?php
                                    $parts=explode("\n", $ship->obligatory_supplements);
                                    ?>
                                @foreach($parts as $p)
                                    <p>{{$p}}</p>
                                @endforeach
                            @endif

                            @if(isset($ship->food) && $ship->food!="")
                                <p class="title-light-blue">Food Options</p>

                                <?php
                                    $parts=explode("\n", $ship->food);
                                    ?>
                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach
                                @if(isset($ship->food_details) && $ship->food_details!="")
                                    <div class="specifications-details">

                                        <?php
                                        $parts=explode("\n", $ship->food_details);
                                        ?>
                                        @foreach($parts as $p)
                                            <p>{{$p}}</p>
                                            @if($p=="")
                                                <br>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                            @endif

                            @if(isset($ship->beverage) && $ship->beverage!="")
                                <p class="title-light-blue">Beverage Options</p>

                                <?php
                                    $parts=explode("\n", $ship->beverage);
                                    ?>

                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach


                                @if(isset($ship->beverage_details) && $ship->beverage_details!="")
                                    <div class="specifications-details">

                                        <?php
                                        $parts=explode("\n", $ship->beverage_details);
                                        ?>
                                    @foreach($parts as $p)
                                        <p>{{$p}}</p>
                                            @if($p=="")
                                                <br>
                                            @endif
                                    @endforeach
                                    </div>
                                @endif

                            @endif

                            @if(isset($ship->options_extra_headline) && $ship->options_extra_headline!="")
                                <p class="title-light-blue">{{$ship->options_extra_headline}}</p>

                                @if($ship->options_extra)
                                    <?php
                                    $parts=explode("\n", $ship->options_extra);
                                    ?>

                                    @foreach($parts as $p)
                                        <li>{{$p}}</li>
                                    @endforeach
                                @endif

                                @if(isset($ship->options_extra_details) && $ship->options_extra_details!="")
                                    <div class="specifications-details">

                                    <?php
                                    $parts=explode("\n", $ship->options_extra_details);
                                    ?>
                                    @foreach($parts as $p)
                                        <p>{{$p}}</p>
                                            @if($p=="")
                                                <br>
                                            @endif
                                    @endforeach
                                    </div>
                                @endif
                            @endif

                            @if(isset($ship->extra_apa) && $ship->extra_apa!="")
                                <p class="title-light-blue">Extra APA</p>
                                <p><strong>APA (Advance Provisioning Allowance): 30% of charter fee</strong></p>
                                <p>To cover the following costs, but not limited to:</p>

                                    <?php
                                    $parts=explode("\n", $ship->extra_apa);
                                    ?>
                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach
                            @endif

                            @if(isset($ship->not_include) && $ship->not_include!="")
                                <p class="title-light-blue">Price does not include:</p>

                                <?php
                                $parts=explode("\n", $ship->not_include);
                                ?>
                                @foreach($parts as $p)
                                    <li>{{$p}}</li>
                                @endforeach
                            @endif
                            @if(isset($ship->not_include_details) && $ship->not_include_details!="")
                                <div class="specifications-details">
                                <?php
                                $parts=explode("\n", $ship->not_include_details);
                                ?>
                                @foreach($parts as $p)
                                    <p>{{$p}}</p>
                                    @if($p=="")
                                        <br>
                                    @endif
                                @endforeach
                                </div>
                            @endif
                        </div>
                    </div>



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
{{--    @if(sizeof($cruises))--}}
{{--        @include("partials.slider",['slider_title' => 'AVAILABLE CRUISES'])--}}
{{--    @endif--}}
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () =>    UI.shipInit()); // (2)
    </script>
@endsection
