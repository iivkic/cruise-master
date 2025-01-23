<div class="tour-info-modal {{(url()->current() == route('booking.step2'))?"summary-modal":""}}">
    <div class="card">
        @if(url()->current() == route('booking.step2'))
            <div class="card-content summary">
                <div class="rating">
                    <span class="rating-value">
                        <span>4.8</span> @svg('/assets/star.svg')</span>
                    <span class="rating-text float-right">(based on 25 reviews)</span>
                </div>
                <div class="line"></div>
                <div class="date">
                    <span class="content-container">
                        <span class="text">Lower cabin</span>
                        <span class="text hide-s">{{isset($input['lower-deck-guests'])?$input['lower-deck-guests']:old('lower-deck-guests')}} per.</span>
                        <span class="text show-s">{{isset($input['lower-deck-guests'])?$input['lower-deck-guests']:old('lower-deck-guests')}} persons</span>
                        <span class="text">2000 EUR</span>
                    </span>
                </div>
                <div class="line"></div>
                <div class="date">
                    <span class="content-container">
                        <span class="text">Lower cabin</span>
                        <span class="text hide-s">{{isset($input['main-deck-guests'])?$input['main-deck-guests']:old('main-deck-guests')}} per.</span>
                        <span class="text show-s">{{isset($input['main-deck-guests'])?$input['main-deck-guests']:old('main-deck-guests')}} persons</span>
                        <span class="text">2500 EUR</span>
                    </span>
                </div>
                <div class="line"></div>
                <div class="date">
                    <span class="content-container">
                        <span class="text">Lower cabin</span>
                        <span class="text hide-s">{{isset($input['sundeck-guests'])?$input['main-deck-guests']:old('main-deck-guests')}} per.</span>
                        <span class="text show-s">{{isset($input['sundeck-guests'])?$input['main-deck-guests']:old('main-deck-guests')}} persons</span>
                        <span class="text">2500 EUR</span>
                    </span>
                </div>
                <div class="line"></div>
                <div class="date">
                    <span class="content-container amount-container">
                        <span class="total-amount-text">Total</span>
                        <span class="total-amount-value">9000 EUR</span>
                    </span>
                </div>
            </div>
        @else
            <div class="card-content">
                <div class="rating">
                        <span class="rating-value">
                            <span>4.8</span> @svg('/assets/star.svg')
                        </span>
                    <span class="rating-text float-right">(based on 25 reviews)</span>
                </div>
                <div class="line"></div>
                <div class="date">
                        <span class="content-container">
                            @svg('/assets/date_2.svg')<span class="text">Date</span>
                            <span class="right-text float-right">03.10.2020</span>
                        </span>
                </div>
                <div class="line"></div>
                <div class="duration">
                        <span class="content-container">
                            @svg('/assets/duration.svg')<span class="text">Duration</span>
                            <span class="right-text float-right">8 days / 7 nights</span>
                        </span>
                </div>
                <div class="line"></div>
                <div class="check-in">
                        <span class="content-container">
                            @svg('/assets/check-in.svg')<span class="text">Check-in</span>
                            <span class="right-text float-right">13:00</span>
                        </span>
                </div>
                <div class="line"></div>
                <div class="vessel-name">
                        <span class="content-container">
                            @svg('/assets/vessel.svg')<span class="text">Vessel name</span>
                            <span class="right-text float-right">MS Bella</span>
                        </span>
                </div>
                <div class="line"></div>
                <div class="start-port">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Embark port</span>
                            <span class="right-text float-right">Dubrovnik</span>
                        </span>
                </div>
                <div class="line"></div>
                <div class="end-port">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Disembark port</span>
                            <span class="right-text float-right">Split</span>
                        </span>
                </div>
            </div>
        @endif
    </div>
</div>
