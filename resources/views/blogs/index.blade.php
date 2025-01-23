@extends('layouts.master')
@section('content')
    <div class="blogs-container">
        <div class="header section">
            <div class="title">
                <h1>Cruise Blog</h1>
            </div>
        </div>
        <div class="content section">
            @foreach($blogs as $blog)
                @if($loop->index!=0)
                    <div class="line"></div>
                @endif
                <div class="blog-post">
                    <a href="{{route("blogs.show",$blog->slug)}}">
                    <div class="post-header">
                        @webp
                        <picture>
                            <source media="(min-width: 768px)" srcset="{{$blog->header_image->webps->thumbnail_1150}}" type="image/webp">
                            <source media="(min-width: 620px)" srcset="{{$blog->header_image->webps->thumbnail_768}}" type="image/webp">
                            <source media="(min-width: 375px)" srcset="{{$blog->header_image->webps->thumbnail_620}}" type="image/webp">
                            <source media="(min-width: 320px)" srcset="{{$blog->header_image->webps->thumbnail_375}}" type="image/webp">

                            <img src="{{$blog->header_image->webps->thumbnail_1150}}" alt="{{$blog->header_image->alt}}" title="{{$blog->header_image->title}}"
                                 class="cover-img">
                        </picture>
                        @else
                            <picture>
                                <source media="(min-width: 768px)" srcset="{{$blog->header_image->thumbnail_1150}}">
                                <source media="(min-width: 620px)" srcset="{{$blog->header_image->thumbnail_768}}">
                                <source media="(min-width: 375px)" srcset="{{$blog->header_image->thumbnail_620}}">
                                <source media="(min-width: 320px)" srcset="{{$blog->header_image->thumbnail_375}}">

                                <img src="{{$blog->header_image->thumbnail_1150}}" alt="{{$blog->header_image->alt}}" title="{{$blog->header_image->title}}"
                                     class="cover-img">
                            </picture>
                            @endwebp
                    </div>
                    </a>
                    <div class="right-container">
                        <div class="post-content">
{{--                            <div class="blog-post-tag">BLOG POSTS</div>--}}
                            <a href="{{route("blogs.show",$blog->slug)}}">
                                <div class="title-light-blue">{{$blog->name}}</div>
                            </a>
                        </div>
                        <div class="line"></div>
                        <div class="post-footer">
                            <span class="date">{{$blog->created_at->format("d/m/Y")}}</span><span class="blue-dot"></span><span class="author">By {{$blog->author?:"mycroatiacruise"}}</span>
                            <a href="{{route("blogs.show",$blog->slug)}}" class="button primary">READ MORE</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
        @include("partials.stories",["blogs"=>$popular])
    </div>
    @include("partials.slider")
    @include("partials.summer")
    @include("partials.blog")
    @include("partials.contact")

    <script>
        document.addEventListener('DOMContentLoaded', () => UI.blogsInit()); // (2)

    </script>
@endsection
