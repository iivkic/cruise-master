<div class="inquiry-notice">
    @svg('assets/inquiry.svg')
    <span>By submitting this inquiry you are not committing to any purchase.</span>
</div>
<div class="offset-container">
    <div class="step-container row">
        <div class="step {!! (url()->current() == route('booking.step1'))?"active":"prev-active" !!} column xs4">
            <span class="number">{!! (url()->current() == route('booking.step1'))?"1":"<span class='check'></span>" !!}</span>
            <p class="text">Select cabin</p>
        </div>
        <div class="step {!! (url()->current() != route('booking.step1'))?(url()->current() == route("booking.step2"))?"active":"prev-active":'' !!} column xs4">
            <span class="number">{!! (url()->current() != route('booking.step1'))?(url()->current() == route("booking.step2"))?"2":"<span class=\"check\"></span>":'2' !!}</span>
            <p class="text">Guest info</p>
        </div>
        <div class="step {!! (url()->current() != route('booking.step1') && url()->current() != route('booking.step2'))?(url()->current() == route("booking.step3"))?"active":"prev-active":'' !!} column xs4">
            <span class="number">{!! (url()->current() != route('booking.step1') && url()->current() != route('booking.step2'))?(url()->current() == route("booking.step3"))?"3":"<span class=\"check\"></span>":'3' !!}</span>
            <p class="text">Send inquiry</p>
        </div>
    </div>
</div>
