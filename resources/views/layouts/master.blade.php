<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="preload" href="/fonts/Montserrat-SemiBold.ttf" as="font" crossorigin/>
    <link rel="preload" href="/fonts/Montserrat-Bold.ttf" as="font" crossorigin/>
    <link rel="preload" href="/fonts/Montserrat-Regular.ttf" as="font" crossorigin/>
    <link rel="preload" href="/fonts/Montserrat-Medium.ttf" as="font" crossorigin/>
    <link href="<?=mix('css/app.css')?>" rel="stylesheet" type="text/css"/>




@if(isset($page_info))
        <title>{{$page_info["meta_title"]}}</title>
        <meta name="description" content="{{$page_info["meta_description"]}}"/>
        @if(isset($page_info["url"]))
            <meta property="og:url" content="{{$page_info["url"]}}" />
            <link rel="canonical" href="<?=$page_info["url"]?>" />


        @endif
        <meta property="og:type"               content="article" />
        <meta property="og:title"              content='{{$page_info["meta_title"]}}' />
        <meta property="og:description"              content='{{$page_info["meta_description"]}}' />
        @if(isset($page_info["image"]))
            <meta property="og:image"              content="{{$page_info["image"]}}" />
        @endif


    @else
        <title>Adriatic Cruises | Small Ship Cruises in Croatia | Croatia Cruise</title>
        <meta name="description" content="Find the most exclusives cruises on Adriatic, choose one way or round trip, enjoy comfort and fully equipped boats, explore beautiful destinations in Croatia."/>
    @endif

    @routes
    <script defer  src="<?=mix('js/app.js')?>"></script>
    <link rel="icon"  href="/fav.ico" sizes="32x32"/>
    {{--    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">--}}
    {{--    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">--}}
    {{--    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">--}}
    {{--    <link rel="manifest" href="/assets/favicon/site.webmanifest">--}}
    {{--    <link rel="mask-icon" href="/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">--}}
{{--    <meta name="description" content="@lang("home.welcome-text")"/>--}}
    @yield("head")
</head>
<body>
@if(Session::get('use_analytics'))
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        // js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endif
<div class="body-overlay" onclick="UI.closeSidebar();UI.hideFilters();UI.closeFilters()"></div>
<div class="navigation-wrapper {{isset($page) && $page=="home"?"home-navigation-wrapper":"sticky nav-fixed"}}">
    @include("partials.navigation.navigation")
</div>
@include("partials.navigation.mobile")
<div class="main-container {{isset($page) && $page=="home"?"home-main-container":"sticky-container"}}">
    @yield("content")
</div>
<footer>
    @if(url()->current() == route('home'))
        @include("partials.footer")
    @else
        @include("partials.footer-other")
    @endif
</footer>
@if(Session::get('show_cookie_consent') || url()->current() == route('privacy'))
    @include("partials.cookie-consent")
@endif

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6220b6201ffac05b1d7cc2e9/1ft7ses4t';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
@if(Session::get('use_analytics'))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-90629328-36"></script>

{{--stari dataLayer--}}
{{--<script>--}}
{{--    window.dataLayer = window.dataLayer || [];--}}
{{--    function gtag(){dataLayer.push(arguments);}--}}
{{--    gtag('js', new Date());  gtag('config', 'UA-90629328-36');--}}
{{--</script>--}}

{{--novi dataLayer--}}
<script>
    window.dataLayer = window.dataLayer || [];
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NF4CMRH');</script>
<!-- End Google Tag Manager -->

{{--<script>--}}
{{--    !function(f,b,e,v,n,t,s)--}}
{{--    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?--}}
{{--        n.callMethod.apply(n,arguments):n.queue.push(arguments)};--}}
{{--        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';--}}
{{--        n.queue=[];t=b.createElement(e);t.async=!0;--}}
{{--        t.src=v;s=b.getElementsByTagName(e)[0];--}}
{{--        s.parentNode.insertBefore(t,s)}--}}
{{--        // (window,document,'script',--}}
{{--        // 'https://connect.facebook.net/en_US/fbevents.js');--}}
{{--    fbq('init', '991789440898015');--}}
{{--    fbq('track', 'PageView');--}}
{{--</script>--}}
{{--<noscript>--}}
{{--    <img height="1" width="1" src="https://www.facebook.com/tr?id=991789440898015&ev=PageView&noscript=1" alt="facebook"/>--}}
{{--</noscript>--}}
@endif
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NF4CMRH"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
@if($usesRecaptcha??true)
{!!  GoogleReCaptchaV3::init() !!}
    @endif
</html>

