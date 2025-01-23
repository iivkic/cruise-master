@extends('layouts.master')
@section('content')
    <div class="blog-container">
        <div class="content section">
            <div class="blog-post">
                <div class="post-header">
                    <span class="date">{{$blog->created_at->format("d/m/Y")}}</span><span class="blue-dot"></span><span class="author">By {{$blog->author?:"mycroatiacruise"}}</span>
                    <h1 class="title-light-blue">{{$blog->name}}</h1>
                    @webp
                    <picture>

                        <source media="(max-width: 375px)" srcset="{{$blog->header_image->webps->thumbnail_620}}" type="image/webp">
                        <source media="(max-width: 620px)" srcset="{{$blog->header_image->webps->thumbnail_768}}" type="image/webp">
                        <source media="(max-width: 768px)" srcset="{{$blog->header_image->webps->thumbnail_1150}}" type="image/webp">

                        <img src="{{$blog->header_image->webps->thumbnail_1150}}" alt="{{$blog->header_image->alt}}" title="{{$blog->header_image->title}}"
                             class="cover-img">
                    </picture>
                    @else
                        <picture>

                            <source media="(max-width: 375px)" srcset="{{$blog->header_image->thumbnail_620}}">
                            <source media="(max-width: 620px)" srcset="{{$blog->header_image->thumbnail_768}}">
                            <source media="(max-width: 768px)" srcset="{{$blog->header_image->thumbnail_1150}}">

                            <img src="{{$blog->header_image->thumbnail_1150}}" alt="{{$blog->header_image->alt}}" title="{{$blog->header_image->title}}"
                                 class="cover-img">
                        </picture>
                        @endwebp
                </div>
                <div class="post-content">
                    {!! $blog->text !!}
                </div>
            </div>
        </div>
        @include("partials.stories")
    </div>
    @include("partials.slider")
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.blogInit()); // (2)
    </script>
@endsection
