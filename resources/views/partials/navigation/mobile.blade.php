
<div id="sidebar" class="sidebar">
    <div class="title"><a href="/">@svg('assets/mcc-logo.svg','logo')</a> <a onclick="UI.closeSidebar()" class="button link">@svg('assets/close.svg','close')</a></div>
    <div class="top-menu">
        <a href="{{route('home')}}">HOME</a>
        <a href="{{route('cruises.index')}}">CRUISES</a>
{{--        <a href="{{route('cruises.cruiseAndStay')}}">CRUISE AND STAY</a>--}}
        <a href="{{route('ships.index')}}">SHIPS</a>
        <a href="{{route('charters.index')}}">CHARTERS</a>
        <a href="{{route('destinations.index')}}">DESTINATIONS</a>
        <a href="{{route('faq')}}">FAQ</a>

    </div>
    <div class="bottom-menu">
        <a class="icon_prefix submenu-trigger" data-target="platforms"><span class="icon">@svg('assets/platforms.svg')</span><span>Selling platforms</span><i
                    class="arrow right"></i></a>
        <a class="icon_prefix" href="/cruise-ports"><span class="icon">@svg('assets/pin.svg')</span><span>Starting ports</span></a>
        <a class="icon_prefix" href="/cruise-news"><span class="icon">@svg('assets/blog.svg')</span><span>Blog</span></a>
        <a class="icon_prefix submenu-trigger" data-target="contact_us"><span class="icon">@svg('assets/email.svg')</span><span>Contact Us</span><i
                    class="arrow right"></i></a>
        <a class="icon_prefix submenu-trigger" data-target="currency"><span class="icon">@svg('assets/currency.svg')</span><span class="currency-value">{{session()->get("currency",["valuta"=>"Eur"])["valuta"]}}</span><i
                    class="arrow right"></i></a>
        <a class="icon_prefix wishlist-container submenu-trigger {{sizeof(session()->get("wishlist",[]))<1?"disabled":""}}" data-target="wishlist"><div class="icon">@svg('assets/wishlist.svg','empty') <p class="wishlist-counter">{{sizeof(session()->get("wishlist",[]))}}</p></div><span>Wishlist</span><i class="arrow right"></i></a>
    </div>
    <div class="sidebar-footer">
        <div class="label">Follow us</div>
        <div class="socials">
            <div class="social">
                <a class="button icon icon-social" href="https://www.facebook.com/MyCroatiaCruise">@svg('assets/facebook.svg')</a>
            </div>
{{--            <div class="social">--}}
{{--                <a class="button icon icon-social" href="">@svg('assets/instagram.svg')</a>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
<div id="wishlist" class="submenu wishlist_sub">
    <div class="title"><a onclick="UI.closeSubmenu()" class="button closebtn link">@svg('assets/back.svg')</a> <div class="text">Wishlist (<span class="wishlist-counter">{{sizeof(session()->get("wishlist",[]))}}</span>)</div> <a onclick="UI.closeSidebar()" class="button link">@svg('assets/close.svg','close')</a></div>
    <div class="submenu-items wishlist">
        @include("ajax.wishlist")
    </div>
</div>
<div id="currency" class="submenu currency_sub">
    <div class="title"><a onclick="UI.closeSubmenu()" class="button closebtn link">@svg('assets/back.svg')</a> <div class="text">Currency</div> <a onclick="UI.closeSidebar()" class="button link">@svg('assets/close.svg','close')</a></div>
    <div class="submenu-items">
        @foreach($currencies as $c)
            <div class="currency-item submenu-item column xs6">
                <a data-currency="{{$c["valuta"]}}" data-step="{{1*50}}" data-value="{{str_replace(",",".",$c["prodajni_tecaj"])/1}}" onclick="UI.setCurrency(this,'{{$c['valuta']}}')" class="column xs6 currency-column list">
                    <span class="value">{{$c["valuta"]}}</span> <span class="name">{{isset($c["name"])?$c["name"]:"nema"}}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
<div id="platforms" class="submenu platforms_sub">
    <div class="title"><a onclick="UI.closeSubmenu()" class="button closebtn link">@svg('assets/back.svg')</a> <div class="text">Selling platforms</div> <a onclick="UI.closeSidebar()" class="button link">@svg('assets/close.svg','close')</a></div>
    <div class="submenu-items ">

            <a class="submenu-item column xs6"  href="https://www.croatiaholidays.travel/"
                   target="_blank">
                    <span>Croatia Holidays</span>
                </a>

            <a class="submenu-item column xs6"  href="https://www.adriatic-explore.com/"
                   target="_blank">
                    <span>Adriatic Explore</span>

            </a>
    </div>
</div>
<div id="contact_us" class="submenu contact_us_sub">
    <div class="title"><a onclick="UI.closeSubmenu()" class="button closebtn link">@svg('assets/back.svg')</a> <div class="text">Contact us</div> <a onclick="UI.closeSidebar()" class="button link">@svg('assets/close.svg','close')</a></div>
    <div class="submenu-items ">
            <a href="tel:00385911145000" class="submenu-item icon_prefix wishlist-item">
                <span class="icon">@svg('assets/phone.svg')</span>
                <div class="title-container"><div class="value">Call Us</div><div class="label">+385 91 11 45 000</div></div>
            </a>
            <a href="mailto:info@ch.hr"  class="submenu-item icon_prefix wishlist-item">
                <span class="icon">@svg('assets/email_fill.svg')</span>
                <div class="title-container"><div class="value">Send Us Message</div><div class="label">info@ch.hr</div></div>
            </a>
            <a href="{{route('about-us')}}"  class="submenu-item icon_prefix wishlist-item">
                <span class="icon">@svg('assets/about.svg')</span>
                <div class="title-container"><div class="value">About Us</div><div class="label">Meet the team</div></div>
            </a>
    </div>
</div>
<form id="search" action="/adriatic-cruises-croatia" class="sidebar">
    <input name="month" type="hidden">
    <div class="title"><div class="text">Search cruises</div> <a onclick="UI.closeSidebar()" class="button link">@svg('assets/close.svg','close')</a></div>
    <div class="bottom-menu">
                <input type="text" readonly  value="{{isset($month)?$month->format("m Y"):""}}" data-start-year="{{$departures->min("date")->year}}"
                       data-final-year="{{$departures->max("date")->year}}" data-events="{{$departures->toJSON()}}" data-inline="true" class="month-picker month-picker">
    </div>
    <div class="sidebar-footer">
        <button {{(url()->current() == route('home'))?'onclick=UI.closeSidebar()':''}} class="button w100 primary">APPLY</button>
    </div>

</form>
