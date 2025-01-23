@foreach($excursions as $trip)
    @if(url()->current() == route('cruises.lmd') && $trip->prices->max("popust") == 0)
        @continue
    @else
        <div class="card cruise column order-{{$loop->index}} xs12 m6 l6 xl4 xxl3 {{session()->get("detailed_view",1)?"detailed":""}}">
            <a class="card-link" href="{{route("cruises.show","$trip->slug")}}">
                <div class="card-header">
                    {{--                {{ dd($trip->ship) }}--}}
                    @webp
                    <picture>
                        <source media="(max-width: 320px)"
                                srcset="{{$trip->ship->header_image->webps->thumbnail_320}}" type="image/webp">
                        <source media="(max-width: 375px)"
                                srcset="{{$trip->ship->header_image->webps->thumbnail_375}}" type="image/webp">
                        <source media="(max-width: 620px)"
                                srcset="{{$trip->ship->header_image->webps->thumbnail_620}}" type="image/webp">
                        <source media="(max-width: 768px)"
                                srcset="{{$trip->ship->header_image->webps->thumbnail_620}}" type="image/webp">
                        <source media="(max-width: 1150px)"
                                srcset="{{$trip->ship->header_image->webps->thumbnail_620}}" type="image/webp">
                        <img src="{{$trip->ship->header_image->webps->thumbnail_620}}" alt="{{$trip->ship->header_image->alt}}"
                             title="{{$trip->ship->header_image->title}}"
                             class="cover-img">
                    </picture>
                    @else
                        <picture>
                            <source media="(max-width: 320px)"
                                    srcset="{{$trip->ship->header_image->thumbnail_320}}" type="image/jpg">
                            <source media="(max-width: 375px)"
                                    srcset="{{$trip->ship->header_image->thumbnail_375}}" type="image/jpg">
                            <source media="(max-width: 620px)"
                                    srcset="{{$trip->ship->header_image->thumbnail_620}}" type="image/jpg">
                            <source media="(max-width: 768px)"
                                    srcset="{{$trip->ship->header_image->thumbnail_620}}" type="image/jpg">
                            <source media="(max-width: 1150px)"
                                    srcset="{{$trip->ship->header_image->thumbnail_620}}" type="image/jpg">
                            <img src="{{$trip->ship->header_image->thumbnail_620}}" alt="{{$trip->ship->header_image->alt}}"
                                 title="{{$trip->ship->header_image->title}}"
                                 class="cover-img">
                        </picture>
                        @endwebp
                        @if($trip->prices->max("popust")>0)
                            <div class="tag {{($trip->last_minute_deal == 1 && url()->current() != route('cruises.lmd'))?"early-booking":""}}">{{($trip->last_minute_deal == 1 && url()->current() != route('cruises.lmd'))?"Special offer":"Great value"}}</div>
                        @endif

                        @if($trip->great_bargain == 1)
                            <div class="tag {{$trip->great_bargain == 1 ? "recommend" : ""}}">@svg('assets/dollar.svg'){{($trip->great_bargain == 1 ? "Great bargain": "")}}</div>
                        @endif
                </div>
                <div class="card-content">
                    <div class="left">
                        <div class="card-title">
                            <div class="ship-name">
                                @isset($trip->ship->name)
                                    {{$trip->ship->name}}
                                @endisset
                            </div>
                            <div class="from-to">
                                @if(isset($trip->start) && isset($trip->finish))
                                    {{$trip->start->name}} to {{$trip->finish->name}}
                                @endif
                            </div>
                        </div>
                        <div class="category">
                            <span>{{$trip->ship->category->name}}</span> ({{$trip->duration->short}})
                        </div>
                        <div class="line"></div>
                        <div class="locations">
                            @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                <div class="vertical-center">
                                    @foreach($trip->destinations as $destination)
                                        {{$loop->index!=0?" - ":""}}
                                        <a href="/cruise-croatia-coast/{{$destination->slug}}" class="destination-link">{{$destination->name}}</a>
                                    @endforeach
                                </div>
                            @else
                                Multiple routes available!
                            @endif
                        </div>
                        <div class="line"></div>

                    </div>
                    <div class="right">
                        {{--                    <div class="rating-wrapper">--}}
                        {{--                        <div class="rating"><span>4.{{5+$trip->id%5}}</span>--}}
                        {{--                            @svg('assets/star.svg','star')--}}
                        {{--                        </div>--}}
                        {{--                        <span>(based on {{$trip->rating_number?:$trip->id*13}} reviews)</span>--}}
                        {{--                    </div>--}}
                        <div class="line"></div>
                        <div class="price-container">
                            @if($trip->min_price->popust>0)
                                @if(!(url()->current() == route('cruises.lmd')))
                                    <div class="discount {{session()->get("detailed_view",1)?"hide-xl":""}}">
                                        <div>save up to {{$trip->min_price->popust>0?(int)$trip->min_price->popust:""}}%</div>
                                        <div class="original_price">
                                            <?=show_currency_price($trip->min_price->price, "striketrough", "EUR")?>
                                        </div>
                                    </div>
                                    <div class="discount hide {{session()->get("detailed_view",1)?"show-xl":""}}">
                                        <div>save up to {{$trip->min_price->popust>0?(int)$trip->min_price->popust:""}}%</div>
                                        <div class="price">
                                            <?=show_currency_price($trip->min_price->real_price, null, "EUR")?>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if((url()->current() == route('cruises.lmd')))
                                @foreach($trip->prices->sortBy('real_price') as $price)
                                    @if($price->popust > 0)
                                        <div class="discount {{session()->get("detailed_view",1)?"hide-xl":""}}">
                                            <div>save up to {{$price->popust>0?(int)$price->popust:""}}%</div>
                                            <div class="original_price">
                                                <?=show_currency_price($price->price, "striketrough", "EUR")?>
                                            </div>
                                        </div>
                                        <div class="discount hide {{session()->get("detailed_view",1)?"show-xl":""}}">
                                            <div>save up to {{$price->popust>0?(int)$price->popust:""}}%</div>
                                            <div class="price">
                                                <?=show_currency_price($price->real_price, null, "EUR")?>
                                            </div>
                                        </div>
                                        <div class="prices {{session()->get("detailed_view",1)?"hide-xl":""}}">
                                            @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                                <div class="label">Price from</div>
                                            @else
                                                <div class="label">Price</div>
                                            @endif
                                            <div class="price">
                                                @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                                    <?=show_currency_price($price->real_price, null, "EUR")?>
                                                @else
                                                    On request.
                                                @endif
                                            </div>
                                        </div>
                                        <div class="prices hide {{session()->get("detailed_view",1)?"show-xl":""}}">
                                            @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                                <div class="label">Price from</div>
                                            @else
                                                <div class="label">Price</div>
                                            @endif
                                            <div class="original_price">
                                                @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                                    <?=show_currency_price($price->price, "striketrough", "EUR")?>
                                                @else
                                                    On request
                                                @endif
                                            </div>
                                        </div>
                                        @break
                                    @endif
                                @endforeach
                            @else
                                <div class="prices {{session()->get("detailed_view",1)?"hide-xl":""}}">
                                    @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                        <div class="label">Price from</div>
                                    @else
                                        <div class="label">Price</div>
                                    @endif
                                    <div class="price">
                                        @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                            <?=show_currency_price($trip->min_price->real_price, null, "EUR")?>
                                        @else
                                            On request.
                                        @endif
                                    </div>
                                </div>
                                <div class="prices hide {{session()->get("detailed_view",1)?"show-xl":""}}">
                                    @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                        <div class="label">Price from</div>
                                    @else
                                        <div class="label">Price</div>
                                    @endif
                                    @if(!($trip->min_price->popust>0))
                                        <div class="price">
                                            @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                                <?=show_currency_price($trip->min_price->real_price, null, "EUR")?>
                                            @else
                                                On request
                                            @endif
                                        </div>
                                    @else
                                        <div class="original_price">
                                            @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                                                <?=show_currency_price($trip->min_price->price, "striketrough", "EUR")?>
                                            @else
                                                On request
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </a>
            <div class="card-prices">
                @if(!in_array($trip->main_excursion->partner_id, array(12,13,14,15)))
                    <div class="prices">
                        @foreach($trip->departures as $time)
                            @if(url()->current() == route('cruises.lmd'))
                                @if($time->min_price->popust > 0)
                                    @if($time->date->gt(now()))
{{--                                        <a onclick="UI.formSubmit({{$time->id}})">//ovo je bilo da se odmah baci na korak za bukiranje--}}
                                        <a href="{{route("cruises.show","$trip->slug")}}">
                                            <div class="price {{!$time->open?"disabled":""}}">
                                                <div class="time">{{date_to_user($time->date)}}</div>
                                                <div class="amount"><?= !$time->open ? '<span class="full">FULL</span>' : "from " . show_currency_price($time->min_price->real_price, null, "EUR")?></div>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            @else
                                @if($time->date->gt(now()))
{{--                                    <a onclick="UI.formSubmit({{$time->id}})"> //ovo je bilo da se odmah baci na korak za bukiranje --}}
                                    <a href="{{route("cruises.show","$trip->slug")}}">
                                        <div class="price {{!$time->open?"disabled":""}}">
                                            <div class="time">{{date_to_user($time->date)}}</div>
                                            <div class="amount"><?= !$time->open ? '<span class="full">FULL</span>' : "from " . show_currency_price($time->min_price->real_price, null, "EUR")?></div>
                                        </div>
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="line"></div>
            {{--        <div class="card-footer">--}}
            {{--            <div class="download-container">--}}
            {{--                @svg('assets/download.svg')<a href="{{route("cruises.download",$trip->slug)}}" class="button link">DOWNLOAD BROCHURE</a>--}}
            {{--            </div>--}}
            {{--        </div>--}}
        </div>
    @endif
@endforeach


