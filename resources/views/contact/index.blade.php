@extends('layouts.master')
@section('content')

    <div class="contact-container">

        @if(isset($_GET['subject']))
            <h1 class="title section">{{isset($_GET['subject']) ? $_GET['subject'] : (old('subject') or '')}}</h1>
        @else
            <h1 class="title section">We are here to take you on a cruise of your life!</h1>
        @endif
        <div class="content">
            <div class="right-content section">
                <div class="card">
                    <div class="card-header">
                    @webp
                        <picture>
                            <source media="(min-width: 1200px)" srcset="/images/ships/ship_375.webp" type="image/webp">
                            <source media="(min-width: 768px)" srcset="/images/ships/ship_1150.webp" type="image/webp">
                            <source media="(min-width: 620px)" srcset="/images/ships/ship_768.webp" type="image/webp">
                            <source media="(min-width: 375px)" srcset="/images/ships/ship_620.webp" type="image/webp">
                            <source media="(min-width: 320px)" srcset="/images/ships/ship_375.webp" type="image/webp">

                            <img src="/images/ships/ship_375.webp" alt="Croatia Cruise" class="cover-img" />
                        </picture>

                    @else
                        <picture>
                            <source media="(min-width: 1200px)" srcset="/images/ships/ship_375.jpg">
                            <source media="(min-width: 768px)" srcset="/images/ships/ship_1150.jpg">
                            <source media="(min-width: 620px)" srcset="/images/ships/ship_768.jpg">
                            <source media="(min-width: 375px)" srcset="/images/ships/ship_620.jpg">
                            <source media="(min-width: 320px)" srcset="/images/ships/ship_375.jpg">

                            <img src="/images/ships/ship_375.jpg" alt="Croatia Cruise" class="cover-img" />
                        </picture>
                    @endwebp
                    </div>
                    <div class="card-content">
                        <div class=>
                            <span class="content-container">
                                <span class="text text-only">Contact us any time if you need help or just a suggestion. We can help you to choose the best cruise for you!</span>
                            </span>
                        </div>
                        <div class="line"></div>
                        <div class="address">
                            <span class="content-container">
                                <span class="text">Address:</span>
                                <span class="right-text float-right">Vukovarska 26, 20000 Dubrovnik, Croatia</span>
                            </span>
                        </div>
                        <div class="line"></div>
                        <div>
                            <span class="content-container">
                                <span class="text">Tel:</span>
                                <span class="right-text float-right"><a href="tel:+385911145000">+385 91 11 45 000</a></span>
                            </span>
                        </div>
                        <div class="line"></div>
                        <div>
                            <span class="content-container">
                                <span class="text">E-mail:</span>
                                <span class="right-text float-right"><a href="mailto:info@ch.hr">info@ch.hr</a></span>
                            </span>
                        </div>
                        <div class="line"></div>
                        <div>
                            <span class="content-container">
                                <span class="text">Working hours:</span>
                                <span class="right-text float-right">8am - 4pm</span>
                            </span>
                        </div>
                        <a class="expand-info hide-l" href="#">CONTACT INFO</a>
                    </div>
                </div>
            </div>
            <div class="left-content section">
                <div class="form-container second-step-container">

                    <form class="row" id="contact-form">

                        @csrf
                        {!!  GoogleReCaptchaV3::renderField('contact_recaptcha','contact_us') !!}
                        @if(isset($_GET['subject']))
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Departure Date</div>
                                <label for="date"></label>
                                <input id="dep_date" data-toggle="datepicker" name="dep_date" class="datep-btn" autocomplete="off" readonly>
                                <p class="error-message">Please fill out the departure date</p>
                            </div>
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Cruise duration</div>
                                <label for="date"></label>
                                <input  type="number"  name="duration" id="duration" placeholder="ex. 2" value=""  min="2" autocomplete="off">
                                <div class="arrow-container">
                                    @svg('assets/arrow_up.svg', 'arrowUp')
                                    @svg('assets/arrow_down.svg', 'arrowDown')
                                </div>
                            </div>
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Number of people</div>
                                <label for="date"></label>
                                <input  type="number"  name="pax" id="pax" placeholder="ex. 14" value=""  min="2" autocomplete="off">
                                <div class="arrow-container">
                                    @svg('assets/arrow_up.svg', 'arrowUpPax')
                                    @svg('assets/arrow_down.svg', 'arrowDownPax')
                                </div>
                            </div>
                            <div class="input-container column xs12 m6">
                                <div class="input-label">Number of cabins</div>
                                <label for="date"></label>
                                <input  type="number"  name="cabins" id="cabins" placeholder="ex. 5" value=""  min="2" autocomplete="off">
                                <div class="arrow-container">
                                    @svg('assets/arrow_up.svg', 'arrowUpCab')
                                    @svg('assets/arrow_down.svg', 'arrowDownCab')
                                </div>
                            </div>
                            @endif
                        <div class="input-container column xs12 m6">
                            <div class="input-label">Your name*</div>
                            <label for="name"></label>
                            <input type="text" name="name" id="name" placeholder="ex. John Smith" value="{{old('name') or ''}}" />
                            <p class="error-message">Please fill out your name</p>
                        </div>
                        <div class="input-container column xs12 m6">
                            <div class="input-label">Your phone</div>
                            <label for="phone"></label>
                            <input type="tel" name="phone" id="phone" placeholder="ex. +3859876543211" value="{{old('phone') or ''}}"/>
                            <p class="error-message">Please fill out your telephone number</p>
                        </div>
                        <div class="input-container column xs12 m6">
                            <div class="input-label">Your e-mail*</div>
                            <label for="email"></label>
                            <input type="email" name="email" id="email" placeholder="ex. john.smith@gmail.com" value="{{old('email') or ''}}"/>
                            <p class="error-message">Please fill out your email</p>
                        </div>
                        <div class="input-container column xs12 m6">
                            <div class="input-label">Subject*</div>
                            <label for="subject"></label>
                            <input type="text" name="subject" id="subject"  value="{{isset($_GET['subject']) ? $_GET['subject'] : 'New contact form submission'}}"/>
                            <p class="error-message">Please fill out your subject of inquiry</p>
                        </div>
                        <div class="input-container column xs12">
                            <div class="input-label">Your message*</div>
                            <label for="message"></label>
                            <textarea rows="10" name="message" id="message">{!! old('message') or ''!!}</textarea>
                            <p class="error-message">Please fill out your inquiry</p>
                            <div class="required-fields">* Required fields</div>
                        </div>
                        <a onclick="UI.sendMail(); ga('send',{hitType: 'event', eventCategory: 'Send Contact', eventAction: 'click'});" class="button primary tag-manager-trigger">SEND INQUIRY</a>
                    </form>
                </div>
                <div class="modal-overlay"></div>
            </div>
        </div>
    </div>
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.shipInit()); // (2)
        var $sendUrl = "{!! route('contact.sendMail') !!}";
        var $form = "#contact-form";

    </script>
@endsection
