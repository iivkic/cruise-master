@foreach(session()->get("wishlist",[]) as $c)
    @php
        if(isset($c->start) && isset($c->finish)){
        $name = $c->ship->name.": ".$c->start->name." to ".$c->finish->name;
        $removeName = $c->ship->name." (".$c->start->name." to ".$c->finish->name.")";
        } else{
            $name = $c->ship->name;
            $removeName = $c->ship->name;
        }
        $tempname = "";
        //$tooltip = 0;
        if (strlen($name) > 30){
            $tempname = substr($name, 0, 27) . '...';
            //$tooltip = 1;
        }
        else
            $tempname = $name;
    @endphp
    <div id="wishlist_{{$c->id}}" class="submenu-item wishlist-item">
    <a  href="{{route("cruises.show",$c->slug)}}" class="value">

        @webp
        <img src="{{$c->header_image->webps->thumbnail_120}}" class="img"/>
        @else
            <img src="{{$c->header_image->thumbnail_120}}" class="img"/>
            @endwebp

        <span class="title-container">
            <span>{{$tempname}}</span>
        </span>


    </a>
        <a class="delete" onclick="UI.removeFromWishlist({{$c->id}}, '{{$removeName}}')">@svg('assets/delete-wishlist.svg','delete-button')</a>
    </div>
@endforeach
