<div class="row">
    <div class="column xs12">
        <div class="logo"><a href="https://www.croatiaholidays.travel#footer">@svg('assets/footer-logo.svg')</a></div>
    </div>
</div>
<div class="row">
    <div class="column m6 xs12 l5 xxl4">
        <div class="intro section">This website is part of Croatia Holidays Ltd. group and offers Adriatic cruises in
            Croatia.
        </div>
        <div class="company">
            <div class="title">TVRTKA:</div>
            <div class="text">Croatia Holidays d.o.o. putnička agencija<br>
                Croatia Holidays d.o.o. za turizam i usluge, <br>
                turistička agencija <br>
                MBS: 090031594 <br>
                OIB: 36948406604 <br>
                Nadležni sud: Trgovački sud u Dubrovniku <br>
                Share capital (Temeljni kapital): <br>
                15.926,73 EUR (uplaćen u cijelosti) <br>
                PDV ID: HR36948406604
            </div>
        </div>
    </div>
    <div class="column m6 xs12 l3 xxl5">
        <div class="managment section">
            <div class="title">ČLAN UPRAVE / DIREKTOR:</div>
            <div class="text">MAJA BRKIĆ</div>
        </div>
        <div class="section location">
            <div class="title">SJEDIŠTE/ADRESA:</div>
            <div class="text">
                Dr. Ante Starčevića 24,<br>
                20000 Dubrovnik, Croatia <br><br>
                <div class="title">
                    Supervision:<br>Državni Inspektorat; State Inspectorate:<br>Tourist Inspection:
                </div>
                <div class="text">
                    Šubićeva 29, 10 000 Zagreb
                </div>
                <br>
                <span class="blue">Tel:</span><a href="tel:00385911145000">+385 91 11 45 000</a><br>
                <span class="blue">E-mail:</span> <a href="mailto:info@ch.hr">info@ch.hr</a><br><br>
                <span class="blue">Working hours:</span> 8am - 4pm CEST
            </div>
        </div>
    </div>
    <div class="column m6 xs12 payment l4 xxl3">
        <div class="cards">
{{--            <a target="_blank" href="https://www.americanexpress.com/" class="card">--}}
{{--                @webp--}}
{{--                    <img class="card" src="/images/american.webp" alt="American Express">--}}
{{--                @else--}}
{{--                    <img class="card" src="/images/american.png" alt="American Express">--}}
{{--                @endwebp--}}
{{--            </a>--}}
            <a target="_blank" href="https://www.mastercard.hr/" class="card">
                @webp
                    <img class="card" src="/images/master.webp" alt="MasterCard">
                @else
                    <img class="card" src="/images/master.png" alt="MasterCard">
                @endwebp
            </a>
            <a target="_blank" href="https://www.mastercard.hr/" class="card">
                @webp
                    <img class="card" src="/images/maestro.webp" alt="Maestro">
                @else
                    <img class="card" src="/images/maestro.png" alt="Maestro">
                @endwebp
            </a>
            <a target="_blank" href="https://www.visa.com.hr/" class="card">
                @webp
                    <img class="card" src="/images/visa.webp" alt="VISA">
                @else
                    <img class="card" src="/images/visa.png" alt="VISA">
                @endwebp

            </a>
        </div>
        <div class="trustwave">
            <a href="https://www.trustwave.com/home/" target="_blank">
                @webp
                    <img class="" src="/images/trustwave-logo.webp" alt="trustwave">
                @else
                    <img class="" src="/images/trustwave-logo.png" alt="trustwave">
                @endwebp

            </a>
{{--            <div class="covid-footer">--}}
{{--                <a href="{{route('covid')}}">COVID-19 cancellation policy</a>--}}
{{--            </div>--}}
        </div>
        <div class="links">
{{--            <a href="https://www.facebook.com/www.croatiaholidays.travel/" target="_blank" class="button icon icon-45">@svg('assets/facebook.svg')</a>--}}
            <a href="https://www.instagram.com/mycroatia.cruise" target="_blank" class="button icon icon-45">@svg('assets/instagram.svg')</a>

        </div>

    </div>

    <div class="column m12 xs12 disclaimer l8 xxl9">
        <p>
            <strong>Voditelj poslovanja:</strong> Antonia Medo
      | <strong>Pojedinosti o nadležnom tijelu čijem službenom nadzoru podliježe djelatnost
            turističke agencije:</strong> Ministarstvo turizma, Samostalni sektor turističke inspekcije, Trg Republike Hrvatske 8/I,
        1000, Zagreb | <strong>Informacije o platformi za online rješavanje sporova:</strong> U slučaju potrebe podnošenja pritužbi te
        rješavanja potrošačkih sporova online možete se koristiti Platformom za online rješavanje potrošačkih sporova
        (Platforma za ORS). Navedenoj platformi kao i svim potrebnim informacijama možete pristupiti putem linka <a class="button link" href="http://ec.europa.eu/odr">http://ec.europa.eu/odr</a>
        </p>
        <div class="privacy-container xs12 show-l">
            <br>
            <div class="privacy-links">
                <a class="button link"  target="_blank" href="{{route('terms')}}">Terms and conditions</a> | <a class="button link"  target="_blank" href="{{route('privacy')}}">Zaštita podataka/Privacy policy</a> | <a class="button link" target="_blank" href="/croatia-holidays-podnosenje-prigovora.pdf">Podnošenje i rješavanje prigovora potrošača / Dealing with customer complaints</a>
            </div>
        </div>
    </div>
    <div class="column m6 privacy xs12 l4 xxl3">
        <div class="hide show-m hide-l">
            <div class="privacy-links">
                <a class="button link"  target="_blank" href="{{route('privacy')}}">Zaštita podataka/Privacy policy</a> | <a class="button link" target="_blank" href="/croatia-holidays-podnosenje-prigovora.pdf">Podnošenje i rješavanje prigovora potrošača / Dealing with customer complaints</a>
            </div>
        </div>
    <div class="newsletter">
        <div class="label">Subscribe to our newsetter</div>
        <div class="input-container">
            <form id="newsletter_form">
                @csrf
{{--                {!!  GoogleReCaptchaV3::renderField('newsletter_recaptcha','contact_us') !!}--}}
                <input type="text" placeholder="Enter your email" name="email" class="newsletter_input">
                <p class="error-message">Please input a correct email address</p>
                <button class="sufix primary button">SEND</button>
            </form>
        </div>
    </div>

    </div>
    <div class="column privacy-container xs12 show-xs hide-m">
        <div class="privacy-links">
            <a class="button link"  target="_blank" href="{{route('privacy')}}">Zaštita podataka/Privacy policy</a> | <a class="button link" target="_blank" href="/croatia-holidays-podnosenje-prigovora.pdf">Podnošenje i rješavanje prigovora potrošača / Dealing with customer complaints</a>
        </div>
    </div>
</div>
<div class="bottom">
    <div class="all_rights">
        © 2019. All rights reserved. | <a class="button link" href="https://www.adriatic-explore.com/">Adriatic Explore</a> | <a href="https://www.kayak-tours-dubrovnik.com/" class="button link">Kayak Tours Dubrovnik</a> | <a class="button link" href="https://mysplitdaytrips.com/">Split Day Trips</a> |
            <a href="https://www.elaphiteislandsdubrovnik.com/" class="button link">Elaphite Islands Dubrovnik</a> | <a href="http://translate.google.com/translate?hl=&sl=en&tl=hr&u=mycroatiacruise.com" rel="nofollow" class="button link">HR</a>
    </div>
    <div class="powered">
        powered by <a href="https://www.croatiaholidays.travel/" class="button link">Croatia Holidays d.o.o.</a>
    </div>
    <script>
        let $newsletterUrl = "{!! route('newsletter') !!}"
    </script>
</div>
