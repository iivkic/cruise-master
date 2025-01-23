<nav class="main-navigation-wrapper">
{{--    <div class="covid-line" onclick="toggleCovid()">--}}
{{--        <span>For all new reservations no cancellation penalty up to 45 days before departure if...  </span><span class="read-more" onclick="togleCovid()" id="read_more">READ MORE</span>--}}
{{--    </div>--}}

{{--  @include('partials.covid')--}}

    <div class="top_nav">
        <div class="left">
            <div class="dropdown">
                <a class="icon_prefix dropdown-trigger"><span class="icon">@svg('assets/platforms.svg')</span><span>Selling platforms</span><i
                            class="arrow down"></i></a>
                <div class="dropdown-content" tabindex="-1">
                    <a class="item" href="https://adriatic-explore.com/"
                       target="_blank">
                        <span>Adriatic Explore</span>
                    </a>
                    <div class="line"></div>
                    <a class="item" href="https://croatiaholidays.travel"
                       target="_blank">
                        <span>Croatia Holidays</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="right">
            <a class="icon_prefix item" href="{{route('ports.index')}}"><span
                        class="icon">@svg('assets/pin.svg')</span><span>Starting ports</span></a>
            <a class="icon_prefix item" href="{{route('blogs.index')}}"><span class="icon">@svg('assets/blog.svg')</span><span>Blog</span></a>
            <div class="dropdown item">
                <a class="icon_prefix dropdown-trigger"><span class="icon">@svg('assets/email.svg')</span><span>Contact Us</span><i
                            class="arrow down"></i></a>
                <div class="dropdown-content contact-dropdown right" tabindex="-1">
                    <a href="tel:00385911145000" class="icon_prefix icon-item">
                        <span class="icon">@svg('assets/phone.svg')</span>
                        <div class="title-container"><div class="value">Call Us</div><div class="label">+385 91 11 45 000</div></div>
                    </a>
                    <div class="line"></div>
                    <a href="{{route('contact')}}"  class="icon_prefix icon-item">
                        <span class="icon">@svg('assets/email_fill.svg')</span>
                        <div class="title-container"><div class="value">Send Us Message</div><div class="label">info@ch.hr</div></div>
                    </a>
                    <div class="line"></div>
                    <a href="{{route('about-us')}}"  class="icon_prefix icon-item">
                        <span class="icon">@svg('assets/about.svg')</span>
                        <div class="title-container"><div class="value">About Us</div><div class="label">Meet the team</div></div>
                    </a>
                </div>
            </div>

            <div class="dropdown dropdown-currency item">
                <a class="icon_prefix  dropdown-trigger" href="#"><span class="icon">@svg('assets/currency.svg')</span><span class="currency-value">{{session()->get("currency",["valuta"=>"Eur"])["valuta"]}}</span><i
                            class="arrow down"></i></a>
                <div class="dropdown-content row right" tabindex="-1">
                        <div class="title title-column column xs12">Currency</div>
                        @foreach($currencies as $c)
                            <div class="currency-item column xs6">
{{--                            <a data-currency="{{$c["valuta"]}}" data-step="{{$c["jedinica"]*50}}" data-value="{{str_replace(",",".",$c["prodajni_tecaj"])/$c["jedinica"]}}" onclick="UI.setCurrency(this,'{{$c['valuta']}}')" class="column xs6 currency-column list">--}}
                            <a data-currency="{{$c["valuta"]}}" data-step="{{1*50}}" data-value="{{str_replace(",",".",$c["prodajni_tecaj"])/1}}" onclick="UI.setCurrency(this,'{{$c['valuta']}}')" class="column xs6 currency-column list">
                                <span class="value">{{$c["valuta"]}}</span> <span class="name">{{isset($c["name"])?$c["name"]:"nema"}}</span>
                            </a>
                            </div>
                        @endforeach
                </div>
            </div>



            <div class="wishlist-container item {{sizeof(session()->get("wishlist",[]))<1?"disabled":""}}">
                <a class="icon_prefix trigger" href="#"><div class="icon">@svg('assets/wishlist.svg','empty') <p
                                class="wishlist-counter">{{sizeof(session()->get("wishlist",[]))}}</p></div><span>Wishlist</span><i
                            class="arrow down"></i></a>
                <div class="wishlist-content right" tabindex="-1">
                    <div class="wishlist-wrapper">
                        <div class="title-item">
                            <span>Wishlist</span><a class="button link" onclick="UI.emptyWishlist()">Remove All</a>
                        </div>
                        <div class="wishlist">
                            @include("ajax.wishlist")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_nav">
        <div class="left"><a href="{{route("home")}}">@svg('assets/mcc-logo.svg')</a></div>
        <div class="search-container">
            <form id="main_search" action="{{route('cruises.index')}}">
                <input name="month" type="hidden">
                <div class="input-field prefix sufix">
                    <div class="arrow down sufix"></div>
                    <div class="prefix">@svg('assets/date.svg')</div>
                    <input readonly value="{{isset($month)?$month->format("m Y"):(isset($firstMonth)?$firstMonth:"")}}"  data-start-year="{{$departures->min("date")->year}}"
                           data-final-year="{{$departures->max("date")->year}}" data-events="{{json_encode($departures)}}" placeholder="Choose month" type="text" class="month-picker"></div>
{{--                                        <input readonly value="{{isset($month)?$month->format("m Y"):""}}"  data-start-year="{{$departures->min('date')->year}}"--}}
{{--                           data-final-year="{{$departures->max("date")->year}}" data-events="{{$departures->toJSON()}}" placeholder="Choose month" type="text" class="show-m month-picker"></div>--}}
                <div class="input-field">
                    <button class="button primary">SEARCH</button>
                </div>
            </form>
        </div>

        <div class="right show-l">
            <a href="{{route('home')}}">HOME</a>
            <a href="{{route('cruises.index')}}">CRUISES</a>
{{--            <a href="{{route('cruises.cruiseAndStay')}}">CRUISE AND STAY</a>--}}
            <a href="{{route('ships.index')}}">SHIPS</a>
            <a href="{{route('charters.index')}}">CHARTERS</a>
            <a href="{{route('destinations.index')}}">DESTINATIONS</a>
            <a href="{{route('faq')}}">FAQ</a>

        </div>
        <div class="right hide-l">
            <button data-target="search" class="button modal-trigger icon hide-m search-icon nav-search">{{ isset($month)?$month->format('M'):'MAY' }}@svg('assets/search.svg')
            </button>
            <a onclick="UI.openSidebar()">@svg('assets/menu.svg')</a>
        </div>
    </div>
</nav>

