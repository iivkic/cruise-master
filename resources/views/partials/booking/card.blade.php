<div class="card-header">
    @if(url()->current() != route('booking.step2'))
    <div class="hide-l">
        <img src="/images/ships/ship.jpg" alt="Croatia Cruise" class="cover-img" />
    </div>
    @endif
    <div class="show-l">
        <img src="/images/ships/ship.jpg" alt="Croatia Cruise" class="cover-img" />
        <img src="/images/ships/ship.jpg" alt="Croatia Cruise" class="cover-img" />
        <img src="/images/ships/ship.jpg" alt="Croatia Cruise" class="cover-img" />
    </div>
    <div class="tag show-l">Great value</div>
</div>
@if(url()->current() == route('booking.step2'))
<div class="card-content summary">
    <div class="total-amount hide-l">
        Total:<span class="total-amount-value"><span class="price-data">90000</span> EUR</span>
    </div>
    <div class="rating show-l">
                    <span class="rating-value">
                        <span>4.8</span> @svg('/assets/star.svg')</span>
        <span class="rating-text float-right show-s">(based on 25 reviews)</span>
    </div>
    <div class="line show-l"></div>
    <div class="ldg show-l">
        <span class="content-container">
            <span class="text">Lower cabin</span>
            <span class="text guest-count hide-xxl"><span class="count-data">{{isset($input['lower-deck-guests'])?$input['lower-deck-guests']:old('lower-deck-guests')}}</span> per.</span>
            <span class="text guest-count show-xxl"><span class="count-data">{{isset($input['lower-deck-guests'])?$input['lower-deck-guests']:old('lower-deck-guests')}}</span> persons</span>
            <span class="text"><span class="individual-price-data">2000</span> EUR</span>
        </span>
    </div>
    <div class="line show-l"></div>
    <div class="mdg show-l">
        <span class="content-container">
            <span class="text">Main cabin</span>
            <span class="text guest-count hide-xxl"><span class="count-data">{{isset($input['main-deck-guests'])?$input['main-deck-guests']:old('main-deck-guests')}}</span> per.</span>
            <span class="text guest-count show-xxl"><span class="count-data">{{isset($input['main-deck-guests'])?$input['main-deck-guests']:old('main-deck-guests')}}</span> persons</span>
            <span class="text"><span class="individual-price-data">2500</span> EUR</span>
        </span>
    </div>
    <div class="line show-l"></div>
    <div class="sg show-l">
        <span class="content-container">
            <span class="text">Sundeck cabin</span>
            <span class="text guest-count hide-xxl"><span class="count-data">{{isset($input['sundeck-guests'])?$input['sundeck-guests']:old('sundeck-guests')}}</span> per.</span>
            <span class="text guest-count show-xxl"><span class="count-data">{{isset($input['sundeck-guests'])?$input['sundeck-guests']:old('sundeck-guests')}}</span> persons</span>
            <span class="text"><span class="individual-price-data">2500</span> EUR</span>
        </span>
    </div>
    <div class="line show-l"></div>
    <div class="date show-l">
        <span class="content-container amount-container">
            <span class="total-amount-text">Total</span>
            <span class="total-amount-value"><span class="price-data">9000</span> EUR</span>
        </span>
    </div>
    <a class="expand-info hide-l" href="#">VIEW SUMMARY</a>
</div>
@else
<div class="card-content">
    <div class="rating">
                        <span class="rating-value">
                            <span>4.8</span> @svg('/assets/star.svg')</span>
        <span class="rating-text float-right show-s">(based on 25 reviews)</span>
    </div>
    <div class="line show-l"></div>
    <div class="date show-l">
                        <span class="content-container">
                            @svg('/assets/date_2.svg')<span class="text">Date</span>
                            <span class="right-text float-right">03.10.2020</span>
                        </span>
    </div>
    <div class="line show-l"></div>
    <div class="duration show-l">
                        <span class="content-container">
                            @svg('/assets/duration.svg')<span class="text">Duration</span>
                            <span class="right-text float-right">8 days / 7 nights</span>
                        </span>
    </div>
    <div class="line show-l"></div>
    <div class="check-in show-l">
                        <span class="content-container">
                            @svg('/assets/check-in.svg')<span class="text">Check-in</span>
                            <span class="right-text float-right">13:00</span>
                        </span>
    </div>
    <div class="line show-l"></div>
    <div class="vessel-name show-l">
                        <span class="content-container">
                            @svg('/assets/vessel.svg')<span class="text">Vessel name</span>
                            <span class="right-text float-right">MS Bella</span>
                        </span>
    </div>
    <div class="line show-l"></div>
    <div class="start-port show-l">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Embark port</span>
                            <span class="right-text float-right">Dubrovnik</span>
                        </span>
    </div>
    <div class="line show-l"></div>
    <div class="end-port show-l">
                        <span class="content-container">
                            @svg('/assets/port.svg')<span class="text">Disembark port</span>
                            <span class="right-text float-right">Split</span>
                        </span>
    </div>
    <a class="expand-info hide-l" href="#">TOUR INFO</a>
</div>
@endif
