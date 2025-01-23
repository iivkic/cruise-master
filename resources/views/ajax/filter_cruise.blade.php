
<div class="row trips_container">
    @include("ajax.cruises")
</div>
<div  data-offset="{{$excursions->currentPage()+1}}" class="load_more {{$excursions->currentPage()==$excursions->lastPage()?"hide":"visible"}}">
    <button onclick="UI.loadMore()" class="button mw344 primary"
    >MORE CRUISES
    </button>
</div>
@if(!(url()->current() == route('cruises.lmd')))
<div class="help-section">
    <div class="help-text">
        <p>Haven't found what you are looking for?</p>
    </div>
    <div class="help-links">
        <p><a onclick="UI.resetFilters()">RESET YOUR FILTERS</a> | <a onclick="UI.loadPreviousFilters(true)">GO BACK TO PREVIOUS SEARCH</a> | <a onclick="UI.loadRecommendedFilter(true)">LOOK AT OUR RECOMMENDATIONS</a>
    </div>
</div>
@endif
