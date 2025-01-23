@webp
<div class="blog-section parallax-window section" data-position-x="left" data-speed="0.6"
     data-parallax="scroll" data-position-y="top" data-image-src="/images/home-blog-background.webp">
@else
<div class="blog-section parallax-window section" data-position-x="left" data-speed="0.6"
     data-parallax="scroll" data-position-y="top" data-image-src="/images/home-blog-background.jpg">
@endwebp
    @foreach($blogs as $blog)
    <div class="blog-wrapper">
        <div class="title-wrapper">
            <div class="info">
{{--                <span>BLOG POSTS</span>--}}
                <div class="counter-container">@svg('/assets/arrow-previous.svg', 'arrow-prev')<span class="current">{{$loop->index+1}}</span> / <span class="total">{{$loop->count}}</span>@svg('/assets/arrow-next.svg', 'arrow-next')</div>
            </div>
            <div class="title">
                {{$blog->name}}
            </div>
            <div class="line"></div>
            <div class="date"><span>{{$blog->created_at->format("d/m/Y")}}</span><div class="circle"></div><span>By {{$blog->author?:"mycroatiacruise"}}</span></div>
            <a href="{{route('blogs.show', $blog->slug)}}" class="button show-m primary">READ MORE</a>
        </div>
        <div class="image">
            @webp
            <picture>
                <source media="(min-width: 1200px)" srcset="{{$blog->header_image->webps->thumbnail_1150}}" type="image/webp">
                <source media="(min-width: 620px)" srcset="{{$blog->header_image->webps->thumbnail_768}}" type="image/webp">
                <source media="(min-width: 375px)" srcset="{{$blog->header_image->webps->thumbnail_620}}" type="image/webp">
                <source media="(min-width: 320px)" srcset="{{$blog->header_image->webps->thumbnail_375}}" type="image/webp">

                <img src="{{$blog->header_image->webps->thumbnail_1150}}" alt="{{$blog->header_image->alt}}" title="{{$blog->header_image->title}}"
                     class="cover-img">
            </picture>
            @else
                <picture>
                    <source media="(min-width: 1200px)" srcset="{{$blog->header_image->thumbnail_1150}}">
                    <source media="(min-width: 620px)" srcset="{{$blog->header_image->thumbnail_768}}">
                    <source media="(min-width: 375px)" srcset="{{$blog->header_image->thumbnail_620}}">
                    <source media="(min-width: 320px)" srcset="{{$blog->header_image->thumbnail_375}}">

                    <img src="{{$blog->header_image->thumbnail_1150}}" alt="{{$blog->header_image->alt}}" title="{{$blog->header_image->title}}"
                         class="cover-img">
                </picture>
                @endwebp
        </div>
        <div class="hide-m"><a href="{{route('blogs.show', $blog->slug)}}" class="button primary">READ MORE</a></div>
    </div>
    @endforeach
</div>
