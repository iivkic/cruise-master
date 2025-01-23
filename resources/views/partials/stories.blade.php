<div class="popular-stories section">
    <div class="title">Most popular stories</div>
    <div class="stories-slider-wrapper">
        <div id="stories-slider" class="stories-slider slider row">
            @foreach($blogs as $b)
            <div class="card column xs12">
                <a class="card-link" href="{{route("blogs.show",$b->slug)}}">
                    <div class="card-header">
                        @webp
                        <picture>
                            <source media="(min-width: 1920px)" srcset="{{$b->header_image->webps->thumbnail_375}}" type="image/webp">
                            <source media="(min-width: 1200px)" srcset="{{$b->header_image->webps->thumbnail_620}}" type="image/webp">
                            <source media="(min-width: 810px)" srcset="{{$b->header_image->webps->thumbnail_768}}" type="image/webp">
                            <source media="(min-width: 320px)" srcset="{{$b->header_image->webps->thumbnail_375}}" type="image/webp">

                            <img src="{{$b->header_image->webps->thumbnail_375}}" alt="{{$b->header_image->alt}}" title="{{$b->header_image->title}}"
                                 class="cover-img">
                        </picture>
                        @else
                            <picture>
                                <source media="(min-width: 1920px)" srcset="{{$b->header_image->thumbnail_375}}" type="image/webp">
                                <source media="(min-width: 1200px)" srcset="{{$b->header_image->thumbnail_620}}" type="image/webp">
                                <source media="(min-width: 810px)" srcset="{{$b->header_image->thumbnail_768}}" type="image/webp">
                                <source media="(min-width: 320px)" srcset="{{$b->header_image->thumbnail_375}}" type="image/webp">

                                <img src="{{$b->header_image->thumbnail_375}}" alt="{{$b->header_image->alt}}" title="{{$b->header_image->title}}"
                                     class="cover-img">
                            </picture>
                            @endwebp
                    </div>
                    <div class="card-title">{{$b->name}}</div>
                    <div class="line"></div>
                </a>
            </div>
            @endforeach

        </div>
    </div>
</div>
