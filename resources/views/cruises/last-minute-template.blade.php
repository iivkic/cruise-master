<div style="margin: 0; background: #F2F4F5; padding: 61px 0 24px">
    <div class="last-minute-home-box-container" style="margin: 0; width: 100%;">
        <div class="logo" style="text-align: center; margin-bottom: 20px;">
            <img src="https://www.mycroatiacruise.com/images/blue_logo.png" alt="Croatia Cruise Logo" />
        </div>
        <div class="title" style="text-align: center;max-width: 712px;font-family: 'montserrat', sans-serif;margin: 0 auto 20px">
            <h1 style="margin: 0;font-size: 32px;line-height: 48px;letter-spacing: 1.6px;color: #0061A1;">UP TO 20% EARLY BOOKING DISCOUNT ON CERTAIN CRUISES UNTIL MAY 1</h1>
        </div>
        <table class="last-minute-home-box" background="https://www.mycroatiacruise.com/assets/last-minute-background.png" style="position: relative;width: 100%; max-width: 453px;height: 336px;overflow: hidden;padding: 32px;border-radius: 29px; margin: 0 auto; background-repeat: no-repeat; background-position: center center; background-size: cover;">
            <tr>
                <td>
                    <div class="main-container" style="-webkit-box-orient: vertical;-webkit-box-direction: normal;flex-direction: column;">
                        <div class="title-container" style="-webkit-box-ordinal-group: 2;order: 1;font-family: 'montserrat', sans-serif; text-align: center;margin-right: 0;margin-bottom: 24px;">
                            <div class="small-title" style="color: white; font-size: 32px; letter-spacing: 1.6px; font-weight: bold; line-height: 32px">EARLY BOOKING DISCOUNT</div>
                            <div class="big-title" style="color: #8AD1FF; font-size: 50px;letter-spacing: 2.5px;font-weight: bold; line-height: 50px">2023 Cruises</div>
                        </div>
                        <div class="images" style="-webkit-box-ordinal-group: 3;order: 2; margin-right: 0;">
                            @foreach($lmd_images as $lmd)
                                <img style="border-radius: 6px;-o-object-fit: cover;object-fit: cover;-o-object-position: center;object-position: center;width: calc(50% - 8px); height: 120px; {{!($loop->last)?'margin-right: 8px;':''}}" src="https://www.mycroatiacruise.com{{$lmd->header_image->thumbnail_620}}" class="img" alt="Early booking discount" />
                                @endforeach
                        </div>
                    </div>
                    <a style="-webkit-box-ordinal-group: 5;text-decoration: none;font-family: 'montserrat', sans-serif;-webkit-transition: all 0.4s ease;padding: 22px 0;order: 4;border-radius: 31px;background: white;color: #414141;font-size: 15px;letter-spacing: 0.75px;transition: all 0.4s ease; display: block; margin-top: 32px; width: 100%; text-align: center" class="lmd_button" href="https://www.mycroatiacruise.com/special-offer-deals">VIEW CRUISES</a>
                </td>
            </tr>
        </table>
        <div class="more-info-container" style="text-align: center;font-family: 'montserrat', sans-serif;font-size: 14px;line-height: 24px;letter-spacing: 0.7px;">
            <p>For more information contact us on <a href="mailto:info@ch.hr" style="text-decoration: none;color: #1593E6;">info@ch.hr</a></p>
        </div>
    </div>
    <div class="unsubscribe-message" style="max-width: 500px; width: calc(100% - 32px); margin: 84px auto 0; padding: 0 16px;">
        <p style="font-family: 'montserrat', sans-serif; font-size: 13px; line-height: 16px; letter-spacing: 0.65px; color:#858585; text-align: center;">
            If you do not wish to receive our exclusive e-mail offers about current cruise deals and updates about new cruise offers, please unsubscribe at <a href="mailto:info@ch.hr" style="text-decoration: none;color: #1593E6;">info@ch.hr</a>.
        </p>
    </div>
</div>
