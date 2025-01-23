<div class="section featured" id="featured">
    <div class="title">{{isset($slider_title)?$slider_title:"FEATURED"}}</div>
    <div class="title_line"></div>
    <div class="slider-wrapper">
        <div id="featured_slider" class="row slider">
            @foreach($cruises as $trip)

                <div class="card cruise column xs12 m6 l4 xxl3 {{($loop->index < 4)?'show-mobile':''}}">
                    <a class="card-link"
                       href="{{route("cruises.show",["slug"=>$trip->slug])}}">
                        <div class="card-header">
                            @webp
                            <picture>
                                <source media="(min-width: 752px)"
                                        srcset="{{$trip->ship->header_image->webps->thumbnail_620}}" type="image/webp">
                                <source media="(min-width: 620px)"
                                        srcset="{{$trip->ship->header_image->webps->thumbnail_768}}" type="image/webp">
                                <source media="(min-width: 375px)"
                                        srcset="{{$trip->ship->header_image->webps->thumbnail_620}}" type="image/webp">
                                <source media="(min-width: 320px)"
                                        srcset="{{$trip->ship->header_image->webps->thumbnail_375}}" type="image/webp">
                                <img src="{{$trip->ship->header_image->webps->url}}" alt="{{$trip->name}}"
                                     title="{{$trip->ship->header_image->title}}"
                                     class="cover-img">
                            </picture>
                            @else
                                <picture>
                                    <source media="(min-width: 752px)"
                                            srcset="{{$trip->ship->header_image->thumbnail_620}}" type="image/webp">
                                    <source media="(min-width: 620px)"
                                            srcset="{{$trip->ship->header_image->thumbnail_768}}" type="image/webp">
                                    <source media="(min-width: 375px)"
                                            srcset="{{$trip->ship->header_image->thumbnail_620}}" type="image/webp">
                                    <source media="(min-width: 320px)"
                                            srcset="{{$trip->ship->header_image->thumbnail_375}}" type="image/webp">
                                    <img src="{{$trip->ship->header_image->url}}" alt="{{$trip->name}}"
                                         title="{{$trip->ship->header_image->title}}"
                                         class="cover-img">
                                </picture>
                                @endwebp
                                @if($trip->prices->max("popust")>0)
                                    <div class="tag">Great value</div>
                                @endif
                                @if($trip->great_bargain == 1)
                                    <div class="tag {{$trip->great_bargain == 1 ? "recommend" : ""}}">@svg('assets/dollar.svg'){{($trip->great_bargain == 1 ? "Great bargain": "")}}</div>
                                @endif
                        </div>
                        <div class="card-content">
                            <div class="card-title">
                                <div class="ship-name">
                                    {{$trip->ship->name}}
                                </div>
                                @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                <div class="from-to">
                                    @if($trip->ch_ship_id==74)
                                        Private Charter {{ $trip->year }}
                                    @else
                                        {{$trip->start->name}} to {{$trip->finish->name}} {{$trip->year}}
                                    @endif

                                </div>
                                @endif
                            </div>
                            <div class="category">
                                <span class="cat-name">{{$trip->category->name}}</span> ({{$trip->duration->short}})
                            </div>
                            <div class="line"></div>
                            <div class="locations">
                                @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                    @foreach($trip->destinations as $destination)
                                        {{$loop->index!=0?" - ":""}}
                                {{$destination->name}}
                                    @endforeach
                                @else
                                    Multiple routes available!
                                @endif
                            </div>
                            <div class="line"></div>
{{--                            <div class="rating-wrapper">--}}
{{--                                <div class="rating"><span>4.{{5+$trip->id%5}}</span>--}}
{{--                                    @svg('assets/star.svg','star')--}}
{{--                                </div>--}}
{{--                                <span>(based on {{$trip->rating_number?:$trip->id*13}} reviews)</span>--}}
{{--                            </div>--}}
                            <div class="line"></div>
                            <div class="price-container">
                                @if($trip->prices->max("popust")>0)
                                    <div class="discount">
                                        <div>save up to {{$trip->prices->max("popust")}}%</div>
                                        @if($trip->min_price->popust>0)
                                            <div class="original_price">
                                                <?=show_currency_price($trip->min_price->price, "striketrough", "EUR")?>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="prices">
                                    @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                        <div class="label">Price from</div>
                                    @else
                                        <div class="label">Price</div>
                                    @endif
                                    <div class="price">
                                        @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                            <?=show_currency_price($trip->min_price->real_price, null, "EUR")?>
                                        @else
                                            On request
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </a>
{{--                    <div class="line"></div>--}}
{{--                    <div class="card-footer">--}}
{{--                        <div class="download-container">--}}
{{--                            @svg('assets/download.svg')<a href="{{route("cruises.download",$trip->slug)}}" class="button link">DOWNLOAD BROCHURE</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                </div>
            @endforeach
        </div>
    </div>
</div>
