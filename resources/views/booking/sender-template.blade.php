@if(true)
    <div style="margin: 0 auto; padding-top: 61px; padding-bottom: 100px; background: #F2F4F5; font-size: 13px; line-height: 24px; letter-spacing: 0.65px;">

        <div style="text-align: center">
            <img src="https://www.mycroatiacruise.com/images/blue_logo.png" alt="blue_logo" width="130" height="48" />
        </div>
        <div style="margin: 30px 0 70px;">
            <p style="margin: 0 auto; text-align: center; max-width: 512px; width: 100%;">
                <strong>Thank you for your interest in cruising Croatia.</strong><br><br>
                You will be contacted shortly by one of our local experts
                who will assist you in organizing the best Croatia Cruise Holiday
                and answer any questions you might have regarding the cruise
                trip.<br><br>

                In the meantime, feel free to <a style="text-decoration: none; position: relative; top: -0.04rem; color: #1593E6;" href="mailto:info@ch.hr">e-mail</a> or <a style="text-decoration: none; position: relative; top: -0.04rem; color: #1593E6;" href="tel:+385911145000">call us</a> directly
                for more information about our cruises.
            </p>
        </div>
{{--        {{dd($departure)}}--}}
        <div style="width: 100%; max-width: 904px; background: white; border-radius: 13px; margin: 0 auto 44px auto;">
            <div style="width: 90%; margin: auto;padding: 59px 0 77px">
                <p style="margin: 0 0 33px; font-size: 18px; letter-spacing: 0.9px;"><strong>Cruise info</strong></p>
                <div style="border-top: 1px solid #E4ECF1; height: auto; min-height: 64px; display: inline-block; width: 100%;">
                    <p style="line-height: 64px; margin: 0; color: #9E9E9E; float:left; width: 50%; text-align: left;">Date</p>
                    <p style="line-height: 64px; margin: 0; color: #414141; float: right; width: 50%; text-align: right;">{{date_to_user($excursion->prices[0]->date)}}</p>
                </div>
                <div style="border-top: 1px solid #E4ECF1;  height: auto; min-height: 64px;display: inline-block; width: 100%;">
                    <p style="line-height: 64px; margin: 0; color: #9E9E9E; float:left;width: 50%; text-align: left;">Duration</p>
                    <p style="line-height: 64px; margin: 0; color: #414141; float: right;width: 50%; text-align: right;">{{$departure->excursion->duration->name}}</p>
                </div>
                <div style="border-top: 1px solid #E4ECF1;  height: auto; min-height: 64px;display: inline-block; width: 100%;">
                    <p style="line-height: 64px; margin: 0; color: #9E9E9E; float:left;width: 50%; text-align: left;">Vessel name</p>
                    <p style="line-height: 64px; margin: 0; color: #414141; float: right;width: 50%; text-align: right;">{{$excursion->ship->name}}</p>
                </div>
                <div style="border-top: 1px solid #E4ECF1;  height: auto; min-height: 64px;display: inline-block; width: 100%;">
                    <p style="line-height: 64px; margin: 0; color: #9E9E9E; float:left;width: 50%; text-align: left;">Embarkation port</p>
                    <p style="line-height: 64px; margin: 0; color: #414141; float: right;width: 50%; text-align: right;">{{$departure->excursion->start->name}}</p>
                </div>
                <div style="border-top: 1px solid #E4ECF1;  height: auto; min-height: 64px;display: inline-block; width: 100%;">
                    <p style="line-height: 64px; margin: 0; color: #9E9E9E; float:left;width: 50%; text-align: left; ">Disembarkation port</p>
                    <p style="line-height: 64px; margin: 0; color: #414141; float: right;width: 50%; text-align: right; ">{{$departure->excursion->finish->name}}</p>
                </div>
            </div>
        </div>

        <div style="width: 100%; max-width: 904px; background: white; border-radius: 13px; margin: 0 auto 100px auto;">
            <div style="width: 90%; margin:auto; padding: 59px 0 77px">
                <p style="margin: 0 0 33px; font-size: 18px; letter-spacing: 0.9px;"><strong>Price overview</strong></p>
                @php $total_price = 0; @endphp
                    @foreach(collect($excursion->prices)->unique('id') as $price)
<!--                        --><?php //dd($price);?>
                    <div style="border-top: 1px solid #E4ECF1; min-height: 64px; height: auto; padding: 15px 0;display: inline-block; width: 100%; ">
                        <p style="margin: 0; color: #9E9E9E; float:left; width: 50%; text-align: left;">{{$price->room_type->name}}<br>{{$price->people}} person/s</p>
{{--                        <p style="margin: 0; color: #9E9E9E; display: inline-block; text-align: center; width: 33%;">{{$price->people}} person/s</p>--}}
                        <p style="margin: 0; color: #414141; float: right; width: 50%; text-align: right;">{{$price->total}} EUR</p>

                    </div>

                    @php $total_price += $price->total @endphp
                    @endforeach
                    <div style="border-top: 1px solid #E4ECF1;  height: 64px;">
                        <p style="line-height: 64px; margin: 0; color: #9E9E9E; float:left; font-size: 20px; letter-spacing: 1px;">Total</p>
                        <p style="line-height: 64px; margin: 0; color: #414141; float: right; font-size: 20px; letter-spacing: 1px;"><strong>{{$total_price}} EUR</strong></p>
                    </div>
            </div>
        </div>
    </div>
@endif
