@extends('layouts.master')
@section('content')
    <div class="booking-container">
        <div class="title section">Inquiry for Cruise from {{$excursion->start->name}} to {{$excursion->finish->name}}, {{$excursion->ship->name}}</div>
        <div class="content">
            <div class="right-content section">
                <div class="card">
                    <div class="card-header">
                       <div class="show-l">
                                                    @webp
                                                    <img src="{{$excursion->ship->header_image->webps->thumbnail_375}}" alt="{{$excursion->name}}"
                                                         title="{{$excursion->ship->header_image->title}}"
                                                         class="cover-img">
                                                    @else
                                                        <img src="{{$excursion->ship->header_image->thumbnail_375}}" alt="{{$excursion->name}}"
                                                             title="{{$excursion->ship->header_image->title}}"
                                                             class="cover-img">
                                                        @endwebp
                                                        @foreach($excursion->ship->images3 as $img)
                                                            @webp
                                                            <img src="{{$img->webps->thumbnail_375}}" alt="{{$excursion->name}}"
                                                                 title="{{$img->title}}"
                                                                 class="cover-img">
                                                            </picture>
                                                            @else
                                                                <img src="{{$img->thumbnail_375}}" alt="{{$excursion->name}}"
                                                                     title="{{$img->title}}"
                                                                     class="cover-img">
                                                                @endwebp
                                                                @endforeach
                                                </div>
                        @if(collect($excursion->prices)->unique('id')->max("popust")>0)
                            <div class="tag show-l">Great value</div>
                        @endif
                    </div>

                    <div class="card-content summary">
                        <div class="total-amount hide-l">
                            Total:<span
                                    class="total-amount-value"><?=show_currency_price(collect($excursion->prices)->sum("total"), "price-data", "EUR")?></span>
                        </div>
{{--                        <div class="rating show-l">--}}
{{--                    <span class="rating-value">--}}
{{--                        <span>4.{{5+$excursion->id%5}}</span> @svg('/assets/star.svg')</span>--}}
{{--                            <span class="rating-text float-right show-s">(based on {{isset($excursion->rating_number)?$excursion->rating_number:$excursion->id*13}} reviews)</span>--}}
{{--                        </div>--}}
                        <div class="line show-l"></div>
                        @foreach(collect($excursion->prices)->unique('id') as $price)
                            <div class="ldg show-l">
        <span class="content-container">
            <span class="text">{{$price->room_type->name}}</span>
            <span class="text guest-count hide-xxl"><span
                        class="count-data">{{$price->people}}</span> per.</span>
            <span class="text guest-count show-xxl"><span
                        class="count-data">{{$price->people}}</span> persons</span>
            <span class="text"><?=show_currency_price($price->total, "individual-price-data", "EUR")?></span>
        </span>
                            </div>
                            <div class="line show-l"></div>
                        @endforeach

                        <div class="date show-l">
        <span class="content-container amount-container">
            <span class="total-amount-text">Total</span>
            <span class="total-amount-value"><?=show_currency_price(collect($excursion->prices)->sum("total"), "price-data", "EUR")?></span>
        </span>
                        </div>
                        <a class="expand-info hide-l" href="#">VIEW SUMMARY</a>
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
                        <div class="step prev-active column xs4">
                            <span class="number"><span class='check'></span></span>
                            <p class="text">Select cabin</p>
                        </div>
                        <div class="step prev-active column xs4">
                            <span class="number"><span class='check'></span></span>
                            <p class="text">Guest info</p>
                        </div>
                        <div class="step active column xs4">
                            <span class="number">3</span>
                            <p class="text">Send inquiry</p>
                        </div>
                    </div>
                </div>
                <div class="form-container last-step-container">
                    @svg('assets/paper-plane.svg')
                    <p>
                        <strong>Thank you for your interest in cruising Croatia.</strong><br>
                        You will be contacted shortly by one our local experts
                        who will help you organize the best Croatia cruise holiday
                        and answer any questions you might have regarding the cruise
                        trip.<br><br>

                        In the meantime, feel free to <a href="mailto:info@ch.hr">e-mail</a> or <a href="tel:+385911145000">call us</a> directly
                        for more information about our cruises.
                    </p>

                    <a href="{{route('cruises.index')}}" class="button primary">EXPLORE MORE</a>
                </div>
            </div>
        </div>
        <div class="tour-info-modal ">
            <div class="card">
                <div class="card-close hide-l">
                    <div class="title">Summary</div>
                    @svg('/assets/close.svg')
                </div>
                <div class="card-content summary">
                    <div class="rating">
                   <span class="rating-value">
                        <span>4.{{5+$excursion->id%5}}</span> @svg('/assets/star.svg')</span>
                        <span class="rating-text float-right">(based on {{isset($excursion->rating_number)?$excursion->rating_number:$excursion->id*13}} reviews)</span>
                    </div>
                    <div class="line"></div>
                    @foreach(collect($excursion->prices)->unique('id') as $price)
                        <div class="date">
                    <span class="content-container">
                        <span class="text">{{$price->room_type->name}}</span>
                        <span class="text hide-s">{{$price->people}} per.</span>
                        <span class="text show-s">{{$price->people}} persons</span>
                        <span class="text"><?=show_currency_price($price->total, null, "EUR")?></span>
                    </span>
                        </div>
                        <div class="line"></div>
                    @endforeach
                    <div class="date">
                    <span class="content-container amount-container">
                        <span class="total-amount-text">Total</span>
                        <span class="total-amount-value"><?=show_currency_price(collect($excursion->prices)->unique('id')->sum("total"), "price-data", "EUR")?></span>
                    </span>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () =>  UI.bookingInit()); // (2)

    </script>
@endsection
