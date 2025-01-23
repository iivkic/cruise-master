@extends('layouts.master')
@section('content')
    <div class="booking-container">
        <div class="title section">Inquiry for Cruise from {{$departure->excursion->start->name}} to {{$departure->excursion->finish->name}}, {{$departure->excursion->ship->name}}</div>
        <div class="content">
            <div class="right-content section">
                <div class="card">
                    <div class="card-header">
                        <div class="hide-l">
                            @webp
                                <img src="{{$departure->excursion->header_image->webps->thumbnail_120}}" alt="{{$departure->excursion->name}}"
                                     title="{{$departure->excursion->header_image->title}}"
                                     class="cover-img">
                            @else
                                <img src="{{$departure->excursion->header_image->thumbnail_120}}" alt="{{$departure->excursion->name}}"
                                     title="{{$departure->excursion->header_image->title}}"
                                     class="cover-img">
                                @endwebp
                        </div>
                        <div class="show-l">
                            @webp
                                <img src="{{$departure->excursion->header_image->webps->thumbnail_375}}" alt="{{$departure->excursion->name}}"
                                     title="{{$departure->excursion->header_image->title}}"
                                     class="cover-img">
                            @else
                                <img src="{{$departure->excursion->header_image->thumbnail_375}}" alt="{{$departure->excursion->name}}"
                                     title="{{$departure->excursion->header_image->title}}"
                                     class="cover-img">
                                @endwebp
                                @foreach($departure->excursion->images3 as $img)
                                    @webp
                                        <img src="{{$img->webps->thumbnail_375}}" alt="{{$departure->excursion->name}}"
                                             title="{{$img->title}}"
                                             class="cover-img">
                                    </picture>
                                    @else
                                        <img src="{{$img->thumbnail_375}}" alt="{{$departure->excursion->name}}"
                                             title="{{$img->title}}"
                                             class="cover-img">
                                        @endwebp
                                @endforeach
                        </div>
                        @if($departure->prices->max("popust")>0)
                        <div class="tag show-l">Great value</div>
                        @endif
                    </div>


                    <div class="card-content">
{{--                        <div class="rating">--}}
{{--                        <span class="rating-value">--}}
{{--                            <span>4.{{5+$departure->excursion->id%5}}</span> @svg('/assets/star.svg')</span>--}}
{{--                            <span class="rating-text float-right show-s">(based on {{$departure->excursion->rating_number?:$departure->excursion->id*13}} reviews)</span>--}}
{{--                        </div>--}}
                        <div class="line show-l"></div>
                        <div class="date show-l">
                        <span class="content-container">
                            @svg('/assets/date_2.svg')<span class="text">Date</span>
                            <span class="right-text float-right">{{date_to_user($departure->date)}}</span>
                        </span>
                        </div>
                        <div class="line show-l"></div>
                        <div class="duration show-l">
                        <span class="content-container">
                            @svg('/assets/duration.svg')<span class="text">Duration</span>
                            <span class="right-text float-right">{{$departure->excursion->duration->name}}</span>
                        </span>
                        </div>
{{--                        <div class="line show-l"></div>--}}
{{--                        <div class="check-in show-l">--}}
{{--                        <span class="content-container">--}}
{{--                            @svg('/assets/check-in.svg')<span class="text">Check-in</span>--}}
{{--                            <span class="right-text float-right">13:00</span>--}}
{{--                        </span>--}}
{{--                        </div>--}}
                        <div class="line show-l"></div>
                        <div class="vessel-name show-l">
                        <span class="content-container">
                            @svg('/assets/vessel.svg')<span class="text">Vessel name</span>
                            <span class="right-text float-right">{{$departure->excursion->ship->name}}</span>
                        </span>
                        </div>
                        <div class="line show-l"></div>
                        <div class="start-port show-l">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Embark port</span>
                            <span class="right-text float-right">{{$departure->excursion->start->name}}</span>
                        </span>
                        </div>
                        <div class="line show-l"></div>
                        <div class="end-port show-l">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Disembark port</span>
                            <span class="right-text float-right">{{$departure->excursion->finish->name}}</span>
                        </span>
                        </div>
                        <a class="expand-info hide-l" href="#">TOUR INFO</a>
                    </div>


                </div>
            </div>
            <div class="left-content section">
                <div class="inquiry-notice">
                    @svg('assets/inquiry.svg')
                    <span>By submitting this inquiry you are not committing to any purchase.</span>
                </div>
                <div class="offset-container">
                    <div class="step-container row">
                        <div class="step active column xs4">
                            <span class="number">1</span>
                            <p class="text">Select cabin</p>
                        </div>
                        <div class="step  column xs4">
                            <span class="number">2</span>
                            <p class="text">Guest info</p>
                        </div>
                        <div class="step  column xs4">
                            <span class="number">3</span>
                            <p class="text">Send inquiry</p>
                        </div>
                    </div>
                </div>

                <div class="form-container">
                    <form action="{{action('BookingController@step2')}}" onsubmit="return UI.checkPeople()" method="POST">
                        @csrf
                        <input type="hidden" name="allow_next_page" value="1"/>
                        <input type="hidden" name="date" id="date" value="{{$departure->date->format("d.m.Y")}}"/>
                        <input type="hidden" name="subject"
                               value="Inquiry for Cruise from {{$departure->excursion->start->name}} to {{$departure->excursion->finish->name}}, {{$departure->excursion->ship->name}}"/>
                        @foreach($departure->prices as $price)
                        <div class="input-container">
                            <div class="input-label">{{$price->room_type->name}}</div>
                            <select name="number[{{$price->id}}]">
                                <option selected data-text=" " value="0">Number of guests</option>
                                @for($i=-1;$i<10;$i++)
                                    <option data-text=" " value="{{$i+1}}">{{$i+1}}</option>
                                @endfor
                            </select>
                            <div class="price-info">
                                @if($price->popust>0)
                                <p class="original-price">

                                        <?=show_currency_price($price->price, "striketrough", "EUR")?>

                                </p>
                                @endif
                                <p class="discounted-price">  <?=show_currency_price($price->real_price, null, "EUR")?></p>
                                <p class="price-text">per person</p>
                            </div>
                            @if(false)
                            <div class="tag active">ONLY TWO LEFT</div>
                            @endif
                        </div>
                        @endforeach

                        <button type="submit" class="button primary">NEXT STEP</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="tour-info-modal">
            <div class="card">
                <div class="card-close hide-l">
                    <div class="title">Summary</div>
                    @svg('/assets/close.svg')
                </div>
                <div class="card-content">
{{--                    <div class="rating">--}}
{{--                        <span class="rating-value">--}}
{{--                            <span>4.{{5+$departure->excursion->id%5}}</span> @svg('/assets/star.svg')--}}
{{--                        </span>--}}
{{--                        <span class="rating-text float-right">(based on {{$departure->excursion->rating_number?:$departure->excursion->id*13}} reviews)</span>--}}
{{--                    </div>--}}
                    <div class="line"></div>
                    <div class="date">
                        <span class="content-container">
                            @svg('/assets/date_2.svg')<span class="text">Date</span>
                            <span class="right-text float-right">{!! date_to_user($departure->date) !!}</span>
                        </span>
                    </div>
                    <div class="line"></div>
                    <div class="duration">
                        <span class="content-container">
                            @svg('/assets/duration.svg')<span class="text">Duration</span>
                            <span class="right-text float-right">{{$departure->excursion->duration->name}}</span>
                        </span>
                    </div>
                    <div class="line"></div>
{{--                    <div class="check-in">--}}
{{--                        <span class="content-container">--}}
{{--                            @svg('/assets/check-in.svg')<span class="text">Check-in</span>--}}
{{--                            <span class="right-text float-right">13:00</span>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <div class="line"></div>--}}
                    <div class="vessel-name">
                        <span class="content-container">
                            @svg('/assets/vessel.svg')<span class="text">Vessel name</span>
                            <span class="right-text float-right">{{$departure->excursion->ship->name}}</span>
                        </span>
                    </div>
                    <div class="line"></div>
                    <div class="start-port">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Embark port</span>
                            <span class="right-text float-right">{{$departure->excursion->start->name}}</span>
                        </span>
                    </div>
                    <div class="line"></div>
                    <div class="end-port">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Disembark port</span>
                            <span class="right-text float-right">{{$departure->excursion->finish->name}}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
{{--    @include("partials.contact")--}}

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.bookingInit()); // (2)

    </script>
@endsection
