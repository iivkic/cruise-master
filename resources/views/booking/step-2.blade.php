@extends('layouts.master')
@section('content')
    <div class="booking-container">
        <div class="title section hide-l">Inquiry for Cruise from {{$excursion->start->name}} to {{$excursion->finish->name}}, {{$excursion->ship->name}}</div>
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
                        @if($excursion->prices->max("popust")>0)
                            <div class="tag show-l">Great value</div>
                        @endif
                    </div>

                    <div class="card-content summary">
                        <div class="boat-image hide-l"><img src="{{ $excursion->ship->header_image->thumbnail_375 }}" alt="{{$excursion->name}}"></div>
{{--                        <div class="boat-image hide-l"><img src="/images/ships/ship.jpg"></div>--}}
                        <div class="card-title show-l">CRUISE OVERVIEW</div>
{{--                        <div class="rating show-l">--}}
{{--                    <span class="rating-value">--}}
{{--                        <span>4.{{5+$excursion->id%5}}</span> @svg('/assets/star.svg')</span>--}}
{{--                            <span class="rating-text float-right show-s">(based on {{$excursion->rating_number?:$excursion->id*13}} reviews)</span>--}}
{{--                        </div>--}}
                        <div class="line show-l"></div>

                        <div class="card-item show-l">
                            <span class="item-icon">@svg('/assets/vessel-dark-gray.svg')</span>
                            <span class="item-name">Vessel</span>
                            <span class="item-description">MS {{ $excursion->ship->name }}</span>
                        </div>
                        <div class="line show-l"></div>

                        <div class="card-item show-l">
                            <span class="item-icon">@svg('/assets/port-dark-gray.svg')</span>
                            <span class="item-name">Route</span>
                            <span class="item-description">From {{ $excursion->start->name }} to {{ $excursion->finish->name }}</span>
                        </div>
                        <div class="line show-l"></div>

                        <div class="card-item show-l">
                            <span class="item-icon">@svg('/assets/date-dark-gray.svg')</span>
                            <span class="item-name">Date</span>
                            <span class="item-description">{{ date_to_user($excursion->prices[0]->date) }}</span>
                        </div>
                        <div class="line show-l"></div>

                        <div class="card-item show-l">
                            <span class="item-icon">@svg('/assets/duration-dark-gray.svg')</span>
                            <span class="item-name">Duration</span>
                            <span class="item-description">{{ $excursion->duration->name }}</span>
                        </div>
                        <div class="line show-l"></div>
                        <a class="expand-info-boat hide-l" href="#">CRUISE OVERVIEW</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content expences show-l">
                        <div class="card-header-title">
                            <span class="card-title">PRICE OVERVIEW</span>
                            <span class="card-icon">@svg('/assets/credit-card-white.svg')</span>
                        </div>
                    </div>
                    <div class="card-content summary">
                        <div class="total-amount hide-l">
                            Total:<span
                                    class="total-amount-value"><?=show_currency_price($excursion->prices->sum("total"), "price-data", "EUR")?></span>
                        </div>
                        @foreach($excursion->prices->unique('id') as $price)
                            <div class="ldg show-l">
                                <div class="price-container">
                                    <div class="cabin price no-line">
                                        <div class="cabin-title no-line"><strong>{{ $price->room_type->name }}</strong></div>
                                        <div class="cabin-price no-line">{{ $price->people }}x<?= show_currency_price($price->real_price, "individual-price-data", "EUR") ?></div>
                                    </div>

                                    <div class="cabin total no-line">
                                        <div class="cabin-title no-line">{{ $price->people }} persons</div>
                                        <div class="cabin-price no-line"><?=show_currency_price(($price->total), "individual-price-data", "EUR")?></div>
                                    </div>

                                </div>
                            </div>
                            <div class="line show-l"></div>
                        @endforeach

                        <div class="date show-l">
                            <span class="content-container amount-container">
                                <span class="total-amount-text">Total</span>
                                <span class="total-amount-value"><?=show_currency_price($excursion->prices->sum("total"), "price-data", "EUR")?></span>
                            </span>
                        </div>

                        <div class="info show-l">
                            <div class="info-icon no-line">i</div>
                            <div class="info-description">Rates are in Euro currency and stated per person and for double cabin occupancy. <br>Single use available on request.
                                The prices and total amount are orientational. <br>Upon sending the request you will be contacted by one of our cruise experts with a final offer.
                            </div>
                        </div>
                        <a class="expand-info hide-l" href="#">PRICE OVERVIEW</a>
                    </div>
                </div>
            </div>
            <div class="left-content section">
                <div class="inquiry-notice">
                    @svg('assets/inquiry-white.svg')
                    <span>By submitting this inquiry you are not committing to any purchase.</span>
                </div>
{{--                <div class="offset-container">--}}
{{--                    <div class="step-container row">--}}
{{--                        <div class="step prev-active column xs4">--}}
{{--                            <span class="number"><span class='check'></span></span>--}}
{{--                            <p class="text">Select cabin</p>--}}
{{--                        </div>--}}
{{--                        <div class="step active column xs4">--}}
{{--                            <span class="number">2</span>--}}
{{--                            <p class="text">Guest info</p>--}}
{{--                        </div>--}}
{{--                        <div class="step  column xs4">--}}
{{--                            <span class="number">3</span>--}}
{{--                            <p class="text">Send inquiry</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="title-section show-l">Inquiry for Cruise from {{$excursion->start->name}} to {{$excursion->finish->name}}, {{$excursion->ship->name}}</div>
                <div class="form-title">Enter your details</div>

                <div class="form-container second-step-container">
                    <form id="form_step_2" action="{{action('BookingController@step3')}}" onsubmit="return UI.checkInquiry(event)" method="POST">
                        @csrf
                        {!!  GoogleReCaptchaV3::renderField('booking_recaptcha','contact_us') !!}
                        <input type="hidden" name="subject"
                               value="Inquiry for Cruise from {{$excursion->start->name}} to {{$excursion->finish->name}}, {{$excursion->ship->name}}"/>
                        <input type="hidden" name="allow_next_page"
                               value="{{isset($input['allow_next_page'])?$input['allow_next_page']:old('allow_next_page')}}"/>
                        <input type="hidden" value="{{json_encode($excursion)}}" name="excursion">

                        <div class="row">
                            <div class="input-container column xs 3">
                                <div class="input-label">Title</div>
                                <label for="title"></label>
                                <select id="title" name="title" class="title">
                                    <option value="">Select..</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Ms.">Ms.</option>
                                </select>
                                <p class="error-message">Please fill out title</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-container column xs12 m6">
                                <div class="input-label">First name*</div>
                                <label for="first-name"></label>
                                <input type="text" name="first-name" id="first-name" placeholder="ex. John"
                                       value="{{isset($input['first-name'])?$input['first-name']:old('first-name')}}"/>
                                <p class="error-message">Please fill out first name</p>
                            </div>
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Last name*</div>
                                <label for="last-name"></label>
                                <input type="text" name="last-name" id="last-name" placeholder="ex. Smith"
                                       value="{{isset($input['last-name'])?$input['last-name']:old('last-name')}}"/>
                                <p class="error-message">Please fill out last name</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Phone</div>
                                <label for="phone"></label>
                                <input type="tel" name="phone" id="phone" placeholder="ex. +3859876543211"
                                       value="{{isset($input['phone'])?$input['phone']:old('phone')}}"/>
                                <p class="error-message">Please fill out your telephone number</p>
                            </div>
                            <div class="input-container column xs12 m6">
                                <div class="input-label">E-mail*</div>
                                <label for="email"></label>
                                <input type="email" name="email" id="email" placeholder="ex. john.smith@gmail.com"
                                       value="{{isset($input['email'])?$input['email']:old('email')}}"/>
                                <p class="error-message">Please fill out your email</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Country</div>
                                <label for="country"></label>
                                <select name="country" id="country">
                                    <option data-text=" " value="">Select...</option>
                                    @foreach($countries as $country)
                                        <option data-text=" " value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message">Please fill out your country</p>
                            </div>
                            <div class="input-container column xs12 m3">
                                <div class="input-label">Number of travelers</div>
                                <label for="travelers"></label>
                                <input type="text" name="travelers" id="travelers" readonly
                                       value="{{$numberOfTravelers}}"/>
                                <p class="error-message">Please fill out number of travelers</p>
                            </div>
                        </div>

                        <div class="input-container">
                            <div class="input-label">Additional Comment</div>
                            <label for="message"></label>
                            <textarea rows="4" name="message" placeholder="ex. Dietary requirements"
                                      id="message">{!! isset($input['message'])?$input['message']:old('message')!!}</textarea>
                            <p class="error-message">Please fill out your inquiry</p>
                        </div>

                        <div class="inquiry-notice">
                            @svg('assets/inquiry-white.svg')
                            <span>By submitting this inquiry you are not committing to any purchase.</span>
                        </div>

                        <div class="row send-section">
                            <div class="required-fields">* Required fields</div>
                            <button  class="button primary">SEND INQUIRY</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <div class="tour-info-modal summary-modal">
            <div class="card">
                <div class="card-close hide-l">
                    <div class="title">Summary</div>
                    @svg('/assets/close.svg')
                </div>

                <div class="card-content summary">
{{--                        <div class="rating">--}}
{{--                   <span class="rating-value">--}}
{{--                        <span>4.{{5+$excursion->id%5}}</span> @svg('/assets/star.svg')</span>--}}
{{--                            <span class="rating-text float-right">(based on {{$excursion->rating_number?:$excursion->id*13}} reviews)</span>--}}
{{--                        </div>--}}
                    <div class="line"></div>
                    @foreach($excursion->prices as $price)
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
                            <span class="total-amount-value"><?=show_currency_price($excursion->prices->sum("total"), "price-data", "EUR")?></span>
                        </span>
                    </div>
                </div>


            </div>
        </div>

        <div class="boat-modal summary-modal">
            <div class="card">
                <div class="card-close hide-l">
                    <div class="title">Cruise Overview</div>
                    @svg('/assets/close.svg')
                </div>

                <div class="card-content summary">
                    <div class="line"></div>
                    <div class="card-item hide-l">
                        <span class="item-icon">@svg('/assets/vessel-dark-gray.svg')</span>
                        <span class="item-name">Vessel | </span>
                        <span class="item-description">MS {{ $excursion->ship->name }}</span>
                    </div>
                    <div class="line hide-l"></div>

                    <div class="card-item hide-l">
                        <span class="item-icon">@svg('/assets/port-dark-gray.svg')</span>
                        <span class="item-name">Route | </span>
                        <span class="item-description">From {{ $excursion->start->name }} to {{ $excursion->finish->name }}</span>
                    </div>
                    <div class="line hide-l"></div>

                    <div class="card-item hide-l">
                        <span class="item-icon">@svg('/assets/date-dark-gray.svg')</span>
                        <span class="item-name">Date | </span>
                        <span class="item-description">{{ date_to_user($excursion->prices[0]->date) }}</span>
                    </div>
                    <div class="line hide-l"></div>

                    <div class="card-item hide-l">
                        <span class="item-icon">@svg('/assets/duration-dark-gray.svg')</span>
                        <span class="item-name">Duration | </span>
                        <span class="item-description">{{ $excursion->duration->name }}</span>
                    </div>
                </div>

            </div>

        </div>

        <div class="modal-overlay">
            <img src="/assets/loading.gif" alt="loading" />
        </div>
    </div>
{{--    @include("partials.contact")--}}
    <form id="hiddenForm" class="hide" action="{{action('BookingController@step3')}}" method="post">
        @csrf
        <input type="hidden" name="allow_last_page" value="1"/>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () =>  UI.bookingInit()
        ); // (2)

    </script>
@endsection
