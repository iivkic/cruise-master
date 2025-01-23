<div class="summer">
    <div class="white-block show-l {{(url()->current() == route('cruises.index'))?'':'hide'}}"></div>
    @webp
    <picture>
        <source media="(min-width: 768px)"
                srcset="/images/summer2020.webp" type="image/webp">
        <source media="(min-width: 620px)"
                srcset="/images/resized/768/summer2020.webp" type="image/webp">
        <source media="(min-width: 375px)"
                srcset="/images/resized/620/summer2020.webp" type="image/webp">
        <source media="(min-width: 320px)"
                srcset="/images/resized/375/summer2020.webp" type="image/webp">
        <img src="/images/summer2020.webp" alt="Adriatic Cruises Croatia 2020" class="cover">
    </picture>

    @else
        <picture>
            <source media="(min-width: 768px)"
                    srcset="/images/summer2020.jpg">
            <source media="(min-width: 620px)"
                    srcset="/images/resized/768/summer2020.jpg">
            <source media="(min-width: 375px)"
                    srcset="/images/resized/620/summer2020.jpg">
            <source media="(min-width: 320px)"
                    srcset="/images/resized/375/summer2020.jpg">
            <img src="/images/summer2020.jpg" alt="Adriatic Cruises Croatia 2020" class="cover">
        </picture>
    @endwebp
    <div class="section">

        <div class="content">
            <div class="title"><span class="blue">@lang('partials/summer.title-blue')</span> @lang('partials/summer.title')</div>
            <div class="line"></div>
            <div class="text">@lang('partials/summer.text')</div>
            <a href="{{ route('cruises.lmd') }}" class="button primary">@lang('partials/summer.link')</a>
        </div>
    </div>

</div>
