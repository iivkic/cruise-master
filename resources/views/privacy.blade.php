@extends('layouts.master')
@section('content')
    <div class="privacy-container">
        <div class="row section">
            <div class="column xs12">
                <div class="title">
                    <h1>Privacy Policy</h1>
                </div>
            </div>
            <div class="column xs12 l8">
                <div class="terms-section">
                    <div class="terms-text">
                        @lang('privacy.policy-text')
                    </div>
                </div>
            </div>
            <div class="column xs12 l4">
                <div class="related-section">
                    <div class="related-title">Related articles</div>
                    <div class="related-links">
                        <a href="{{route('about-us')}}">About Us</a>
                        <a href="{{route('terms')}}">Terms and Conditions</a>
                        <a href="/croatia-holidays-podnosenje-prigovora.pdf">Dealing with customer complaint</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("partials.slider",["main_title"=>"FEATURED"])
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")
    <script>
        // document.addEventListener('DOMContentLoaded', () =>    UI.shipsInit()); // (2)
    </script>

@endsection
