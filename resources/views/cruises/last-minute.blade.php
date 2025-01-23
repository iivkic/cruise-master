@extends('layouts.master')
@section('content')
    <div class="cruises-container lmd-container">
        <div id="filter-modal" class="modal filters filters-modal main-filters-modal">
            <div class="content">
                <div class="last-minute-box">
                    @svg('assets/large_search.svg')
                    <div class="last-minute-text">
                        <p>Browse through the advanced search filter for our complete cruise deal offers. Set sail with Croatia Cruise all year round and enjoy the wonders of Adriatic Coast. Click to find out more.
                        </p>
                    </div>
                    <a href="{{route('cruises.index')}}" class="primary button">Switch to Search</a>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="content-header row">
                <div class="results-number column "><h1>We offer <span class="number">{{$excursions->total()}}</span> special offer deals</h1></div>
                <div class="line"></div>
                <div class="last-minute-box-xl column">
                    <p>EARLY BIRD DISCOUNT is valid for certain departure dates in 2025. For more detailed information about booking and payment conditions please contact our agents.
                    </p>
                </div>
                <div class="active-filters column hide-xl">
                    <a href="{{route('cruises.lmd')}}" class="button primary filter-trigger lmd-trigger hide-l">
                        <span>Switch to Search</span></a>
                    <div class="filter-list show-l">
                    </div>
                </div>
                <div class="actions column">
                    <div class="label"><span>switch view</span></div>

                    <div class="button icon icon-only {{session()->get("detailed_view",1)==1?"":"active"}}">
                        @svg('assets/general-view.svg','view-config card-view')
                    </div>
                    <div class="button icon icon-only {{session()->get("detailed_view",1)==1?"active":""}}">
                        @svg('assets/detail-view.svg','view-config detailed-view')

                    </div>
                </div>
            </div>

            <div class="results">
                <div class="loading-overlay">
                    <div class="loading-message-container">
                        <div class="loading-message">
                            <img src="/assets/loading.gif" alt="loading gif" width="50" height="50" />
                            <div class="message">Please wait</div>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    @include("ajax.filter_cruise")
                </div>
            </div>
            <form action="{{route("booking.step1")}}" method="POST" class="priceForm">
                @csrf
                <input type="hidden" name="id" value=""/>
                <button class="hide"></button>
            </form>
        </div>
    </div>
    <div class="cruises-summer">
        @include("partials.summer")
    </div>
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.lastMinuteInit()); // (2)
    </script>
@endsection
