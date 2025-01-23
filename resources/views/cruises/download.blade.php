<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>{{"My Croatia Cruise - ".$cruise->name}}</title>
    <meta name="description"
          content="{{$cruise->meta_description}}"/>

</head>
<style>
    body {
        background-color: #F2F4F5;
        margin: 0;
        color:#414141;
        font-family: 'montserrat', sans-serif;

    }
*{
    white-space: normal;
}
    .sb {
        font-family: 'montserratsb', sans-serif;
        font-weight: 600;
    }

    .header {

        background-position: center 65%;
        background-repeat: no-repeat;
        background-size: cover;

    }

    .header-overlay {
        height: 164px;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 97, 161, .6);
        z-index: 0;
        color: white;
        font-size: 24px;
        letter-spacing: 1.2px;
        padding: 80px;
        padding-bottom: 0;
    }

    .header-overlay .title {
        margin-top: 40px;
    }

    .header-overlay .title .small {
        font-size: 16px;
        margin-bottom: 10px;
        letter-spacing: 1.6px;
    }

    .cruise-content-container {
        padding: 0 50px;
    }

    .cruise-content-container .card{
        background-color: white;
        border-radius: 6px;
        box-shadow: 0 0 46px rgba(0,0,0,0.3);
        margin:45px 0 16px 0;
    }
    .summary-card .header{
        border-radius: 6px 6px 0 39px;
        overflow: visible;
        background-position: center 65%;
        background-repeat: no-repeat;
        background-size: cover;

    }
    .summary-card .header .tag{
        float:right;
        width:127px;
        border-radius:207px 6px 6px 207px ;
        padding: 7px 14px;
        background-color: #42B5FF;
        color:white;
        margin-right: -4px;
        margin-top: 6px;
    }
    .summary-card .content{
        padding: 8px 40px;
        padding-bottom: 40px;
    }
    .summary-card .content .table1{

    }
    .summary-card .content .table1 td{
        height:64px;
        font-size: 13px;
        vertical-align: middle;
        border-bottom: 1px solid #E4ECF1;
        color:#9E9E9E;
    }
    .summary-card .content .table1 td.icon{
        width:48px;
    }
    .summary-card .content .table1 .tr{
        color:#414141;
    }
    .text-right,.tr{
        text-align: right;
    }
    .table2 td{
        padding:5px 0;
    }
    .striketrough {
        color: #E61515;
        text-decoration: line-through;
    }
    .red{
        color: #E61515;
    }
    .new-page-wrapper{
        page-break-before: always;
        padding:30px 0;
    }
    .card.ship .header{
        border-radius: 6px;
        /*height:104px;*/
    }
    .card.ship .header .image{
        width:104px;
        float:left;
        display:inline-block;
        padding-bottom: 104px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-image: url('{{$cruise->ship->header_image->url}}');
        border-radius: 6px;
    }

    .webp .card.ship .header .image{
        background-image: url('{{$cruise->ship->header_image->webps->url}}');
    }

        @if($cruise->images&&count($cruise->images)>1)
    .card.ship .header.itinerary .image{

        background-image: url('{{$cruise->images[1]->url}}');
    }

    .webp .card.ship .header.itinerary .image{

        background-image: url('{{$cruise->images[1]->webps->url}}');
    }
    @endif
    .card.ship .header .title{
        display:inline-block;
        /*height:60px;*/
        float:left;
        width:500px;
        padding-top:30px;
        padding-left: 20px;
        color:#1593E6;
        font-size: 20px;
        letter-spacing: 1px;
        margin-bottom:15px;
    }
    .card.ship .content{
        padding-right: 60px;
        padding-left: 22px;
        padding-bottom: 30px;
    }
    .card.ship.itinerary .content{
        padding-right: 45px;
        padding-left: 30px;
        padding-bottom: 30px;
        overflow: auto;
    }
    .card.ship.itinerary .footer{

    }
    .title-inclusions-header{
        margin-bottom: 0 !important;
    }
    .inclusions-section .title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /*height: 80px;*/
        text-align: left;
        font-weight: 400;
        font-size: 27px;
        line-height: 39px;
        letter-spacing: 1.6px;
        margin:10px 0 10px  0 ;
    }
    .inclusions-section .inclusions-item {
        color: #414141;
        padding-bottom: 30px;
        width: 100%;
    }
     .inclusions-section .inclusions-item .details-inclusions {
        font-size: 14px;
        line-height: 32px;
        font-weight: 400;
        letter-spacing: .8px;
    }
    .inclusions-section {
        margin-top: 14px;
        margin-bottom:16px;
        border-radius: 6px;
        background-color: #fff;
        transition: all .4s ease;
        position: relative;
        padding-left: 30px;
        padding-right: 40px;

    }

    .inclusions-section .inclusions-item .title-inclusions {
        font-size: 18px;
        line-height: 22px;
        font-weight: 700;
        letter-spacing: .9px;
        padding-bottom: 12px;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        flex-direction: row;
        justify-content: center;
        margin-top:10px;
    }
    .inclusions-section .inclusions-item .title-inclusions label svg {
        margin-right: 25px;
    }
    .inclusions-section .inclusions-item .title-inclusions label{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        font-size:14px;
        margin-bottom:10px;
    }

    .inclusions-section .inclusions-item .title-inclusions .line {
        height: 1px;
        background-color: #d7dee3;
        right: 0;
        flex-grow: 1;
        /*width:inherit;*/
        margin:10px 50px 0 0;
    }
    .card.ship .content .label{
        margin-bottom: 14px;
        color:#1593E6;
        font-size: 14px;
    }
    .card.ship .content .text{
        margin-bottom: 25px;
        color:#9E9E9E;
        font-size: 14px;
    }
    .card.ship .content .images{
        margin-left: -12px;
    }
    .card.ship .content .images .image{
        width:104px;
        float:left;
        margin-left: 12px;
        display:inline-block;
        padding-bottom: 104px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;

        border-radius: 6px;
    }
    .card.ship.itinerary .content .circle{
        width:16px;
        padding:20px 0;
        padding-right: 30px;
    }

    .card.ship.itinerary .content .subtitle{
        padding-left:10px;
        border-top: 1px solid #D2D9DE;
        color:#1593E6;
        font-size: 14px;
        letter-spacing: 1.7px;
        white-space: nowrap;
        min-width:2%;
    }
    .card.ship.itinerary .content .span{
        color:#B8B8B8;
        border-top: 1px solid #D2D9DE;
        font-size: 14px;
        letter-spacing: 1.7px;
        max-width:100%;
        white-space:nowrap;
    }
    .card.ship.itinerary .content table.line{
        margin-left: 8px;
        padding-left: 22px;
        border-left: 1px solid #D2D9DE;
    }
    .card.ship.itinerary .content .meals {

        padding-bottom: 15px;
        padding-left: 24px;
        color:#9E9E9E;
    }
    .card.ship.itinerary .content .text {
        color:#414141;
        white-space: normal;
    }
    .card.ship.itinerary .content .images{
        padding-bottom:20px;
        margin-left: 8px;
        padding-left: 33px;
        border-left: 1px solid #D2D9DE;

    }
</style>
<body>
@webp
<div class="header section" style="background-image: url('{{$cruise->header_image->webps->url}}')">
@else
<div class="header section" style="background-image: url('{{$cruise->header_image->url}}')">
@endwebp
    <div class="header-overlay sb">
        <div class="title">
            <div class="small">Over 100 amazing cruises in Croatia</div>
            Cruise @if($cruise->start&&$cruise->finish) from {{$cruise->start->name}} to {{$cruise->finish->name}}<br/> @endif with {{$cruise->ship->name}}
        </div>
    </div>

</div>

<div class="cruise-content-container">
    <div class="card summary-card">
        @webp
            <div class="header" style=" @if(isset($cruise->images[0])) background-image: url('{{$cruise->images[0]->webps->url}}'); @else background:#0072BC @endif height:150px;">
                @if($cruise->prices->max("popust")>0)
                    <div class="tag">Great value</div>
                @endif
            </div>
        @else
            <div class="header" style="height:100px; @if(isset($cruise->images[0])) background-image: url('{{$cruise->images[0]->url}}'); @else background:#0072BC @endif height:150px;">
                @if($cruise->prices->max("popust")>0)
                    <div class="tag">Great value</div>
                @endif
            </div>
        @endwebp

        <div class="content">
            <table width="100%">
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" class="table1" width="100%">
                            <tr>
                                <td class="icon">@svg('assets/date_gray.svg',' date-icon icon')</td>
                                <td>Date</td>
                                <td class="tr">From {{$cruise->departures->min("date")->format("F")}}
                                    to {{$cruise->departures->max("date")->format("F")}}
                                </td>
                            </tr>
                            <tr>
                                <td class="icon">@svg('assets/duration.svg',' icon')</td>
                                <td>Duration</td>
                                <td class="tr">{{$cruise->duration->name}}
                                </td>
                            </tr>
                            <tr>
                                <td class="icon">@svg('assets/category.svg',' icon')</td>
                                <td>Category</td>
                                <td class="tr">{{$cruise->category->name}}
                                </td>
                            </tr>
                        </table>
                    </td>


                    <td valign="top">

                        </div>
                        <table class="table2" cellspacing="0" cellpadding="0" style="text-align:right; " width="100%">


                            <tr>
                                <td></td>
                                <td style="color:#B8B8B8;font-size: 20px;font-family: 'montserratsb', sans-serif">Price from</td>
                            </tr>

                            @if($cruise->min_price->max_discount>0)
                                <tr>
                                    <td></td>
                                    <td  style="color:#B8B8B8;letter-spacing: 1.4px;">  <?=show_currency_price($cruise->min_price->price, "striketrough", "EUR")?></td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td class="sb" style="color:#414141;font-size: 20px;letter-spacing: 1px;font-weight: 600"><?=show_currency_price( $cruise->min_price->max_discount>0 ? $cruise->min_price->price*(100-$cruise->min_price->max_discount)/100 : $cruise->min_price->price, null, "EUR")?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="red" style="letter-spacing: 1.4px;"> @if($cruise->min_price->max_discount>0) save up to {{$cruise->min_price->max_discount}}% @endif</td>

                            </tr>
                        </table>

                    </td>

                    <div class="label">Technical specification</div>
                    <div class="text">Year of
                        construction: {{ ($cruise->ship->build && $cruise->ship->build != "")?$cruise->ship->build:"N/A" }}
                        |
                        Length: {!! (isset($cruise->ship->length) && $cruise->ship->length != "")?$cruise->ship->length."m":"N/A" !!}
                        |
                        Beam: {!! (isset($cruise->ship->width) && $cruise->ship->width != "")?$cruise->ship->width."m":"N/A" !!}
                        | Cruising
                        speed: {!! (isset($cruise->ship->speed) && $cruise->ship->speed != "")?$cruise->ship->speed:"N/A" !!}
                        |
                        Cabins: {!! (isset($cruise->ship->cabins_quantity) && $cruise->ship->cabins_quantity != "")?$cruise->ship->cabins_quantity:"N/A" !!}
                        | Cabin
                        sizes: {!! (isset($cruise->ship->cabin_size) && $cruise->ship->cabin_size != "")?$cruise->ship->cabin_size."m<sup>2</sup>":"N/A" !!}
                        |
                        Flag: {!! (isset($cruise->ship->flag) && $cruise->ship->flag != "")?$cruise->ship->flag:"N/A" !!}
                    </div>
                </tr>
            </table>
        </div>
    </div>
    <div>
    <div class="card ship">
        <div class="header">
{{--            <div class="image"></div>--}}
            <div class="title"><span>Technical specification</span></div>
        </div>
        <div class="content">
{{--            <div class="label">Technical specification</div>--}}
            <div class="text">Year of
                construction: {{ ($cruise->ship->build && $cruise->ship->build != "")?$cruise->ship->build:"N/A" }}
                |
                Length: {!! (isset($cruise->ship->length) && $cruise->ship->length != "")?$cruise->ship->length."m":"N/A" !!}
                |
                Beam: {!! (isset($cruise->ship->width) && $cruise->ship->width != "")?$cruise->ship->width."m":"N/A" !!}
                | Cruising
                speed: {!! (isset($cruise->ship->speed) && $cruise->ship->speed != "")?$cruise->ship->speed:"N/A" !!}
                |
                Cabins: {!! (isset($cruise->ship->cabins_quantity) && $cruise->ship->cabins_quantity != "")?$cruise->ship->cabins_quantity:"N/A" !!}
                | Cabin
                sizes: {!! (isset($cruise->ship->cabin_size) && $cruise->ship->cabin_size != "")?$cruise->ship->cabin_size."m<sup>2</sup>":"N/A" !!}
                |
                Flag: {!! (isset($cruise->ship->flag) && $cruise->ship->flag != "")?$cruise->ship->flag:"N/A" !!}
            </div>
            @if(isset($cruise->ship->highlights) && $cruise->ship->highlights != "")
                <div class="label">Highlights</div>
                <div class="text"><p>{!! $cruise->ship->highlights !!}</p>
                </div>
            @endif
{{--            <div class="images">--}}
{{--                @foreach($cruise->images3 as $image)--}}
{{--                    @webp--}}
{{--                        <div class="image" style="background-image: url('{{$image->webps->url}}');"></div>--}}
{{--                    @else--}}
{{--                        <div class="image" style="background-image: url('{{$image->url}}');"></div>--}}
{{--                    @endwebp--}}
{{--                @endforeach--}}
{{--            </div>--}}
        </div>
    </div>
    </div>
    <div  class="new-page-wrapper">
        <div>
            <div class="card ship itinerary">
                <div class="header">
                    {{--                <div class="image"></div>--}}
                    <div class="title"> Itinerary & includes for {{$cruise->itineraries[0]->year}}.</div>
                </div>
    @foreach($cruise->itineraries as $itinerary)
        @foreach($itinerary->days as $day)


            <div class="content">


                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr class="label">
                            <td class="circle" >
                                @if($loop->index==0 || $loop->index==$itinerary->days->count()-1)
                                <svg height="16" width="16">
                                    <circle cx="8" cy="8" r="8" stroke="none" fill="{{$loop->index==0?"#00BC8F":"#E61515"}}" />
                                </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="Group_999" data-name="Group 999" transform="translate(-1181 -15785)">
                                            <g id="Ellipse_154" data-name="Ellipse 154" transform="translate(1181 15785)" fill="none" stroke="#42b5ff" stroke-width="3">
                                                <circle cx="8" cy="8" r="8" stroke="none"/>
                                                <circle cx="8" cy="8" r="6.5" fill="none"/>
                                            </g>
                                            <circle id="Ellipse_155" data-name="Ellipse 155" cx="2" cy="2" r="2" transform="translate(1187 15791)" fill="#42b5ff"/>
                                        </g>
                                    </svg>
                                    @endif
                            </td>
                            <td class="subtitle" >Day {{$day->sequence}}
                                - {{$cruise->departures->first()->date->add($loop->index." days")->format("l")}}
                            </td>
                            <td class="span">
                                                @foreach($day->destinations as $destination){{$loop->index!=0?", ":""}}{{$destination->name}}@endforeach

                            </td>
                        </tr>
                    </table>
                <table width="100%" class="line">
                        <tr>
                            <td  class="meals">  @foreach($day->meals as $meal){{$loop->index!=0?", ":""}}{{$meal->name}}@endforeach</td>
                        </tr>
                        <tr>
                            <td class="meals text">{!! $day->text !!}</td>
                        </tr>

                    </table>
{{--                    <div class="images">--}}
{{--                        @php $counter = 0; @endphp--}}
{{--                        @foreach($day->destinations as $destination)--}}
{{--                            @webp--}}
{{--                                <div class="image" style="background-image: url('{{$destination->header_image->webps->url}}')"></div>--}}
{{--                            @else--}}
{{--                                <div class="image" style="background-image: url('{{$destination->header_image->url}}')"></div>--}}
{{--                            @endwebp--}}
{{--                            @php $counter++; @endphp--}}
{{--                        @endforeach--}}
{{--                        @foreach($day->destinations as $destination)--}}
{{--                            @foreach($destination->images as $image)--}}
{{--                                @if($counter<2)--}}
{{--                                    @webp--}}
{{--                                        <div class="image" style="background-image: url('{{$image->webps->url}}')"></div>--}}
{{--                                    @else--}}
{{--                                        <div class="image" style="background-image: url('{{$image->url}}')"></div>--}}
{{--                                    @endwebp--}}
{{--                                    @php $counter++; @endphp--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endforeach--}}
{{--                    </div>--}}

            </div>

        @endforeach
    @endforeach
            </div>
        </div>
    </div>
    @if(false)



            @foreach($cruise->itineraries as $itinerary)
                @if($itinerary->year<date("Y"))
                @continue
            @endif
                <div id="itinerary">
                    <div class="subsection">
{{--                        @if(isset($cruise->images[0]))--}}
{{--                        <div class="small-icon">--}}
{{--                            <img src="{{$cruise->images[0]->thumbnail_320}}" alt="" class="src">--}}
{{--                        </div>--}}
{{--                        @endif--}}
                        <div class="title main-title">
                            Itinerary & includes for {{$itinerary->year}}.
                            <span class="expand-button show-m">expand all</span>
                        </div>
                        <div class="line"></div>
                        @foreach($itinerary->days as $day)
                            <div class="expendable">

                                <div class="title day" onclick="UI.expand(this)">
                                    <div>Day {{$day->sequence}}
                                        - {{$cruise->departures->first()->date->add($loop->index." days")->format("l")}}
                                        <span>
                                                @foreach($day->destinations as $destination){{$loop->index!=0?", ":""}}{{$destination->name}}@endforeach
                                            </span>
                                    </div>
                                    @svg('assets/choose-month-arrow.svg','expand')
                                </div>
                                <div class="content day">
                                    <div class="label">
                                        @foreach($day->meals as $meal){{$loop->index!=0?", ":""}}{{$meal->name}}@endforeach
                                    </div>
                                    <div class="value">{!! $day->text !!}
                                    </div>
                                    <div class="image-container row">
                                        @php $counter = 0; @endphp
                                        @foreach($day->destinations as $destination)
                                            <a @if($counter==0)id="day{{$day->sequence}}_trigger" @endif
                                            data-lightbox="day{{$day->sequence}}"
                                               href="{{$destination->header_image->url}}"
                                               class="column {{$counter==1 ? "show-m":""}} {{$counter==2 ? "show-xl":""}} @if($counter>2)hide @endif"><img
                                                        src="{{$destination->header_image->thumbnail_375}}"/></a>
                                            @php $counter++; @endphp
                                        @endforeach
                                        @foreach($day->destinations as $destination)
                                            @foreach($destination->images as $image)
                                                <a @if($counter==0)id="day{{$day->sequence}}_trigger" @endif
                                                data-lightbox="day{{$day->sequence}}"
                                                   href="{{$image->url}}"
                                                   class="column {{$counter==1 ? "show-m":""}} {{$counter==2 ? "show-xl":""}} @if($counter>2)hide @endif"><img
                                                            src="{{$image->thumbnail_375}}"/></a>
                                                @php $counter++; @endphp
                                            @endforeach
                                        @endforeach
                                        <a class="column trigger count-{{$counter+1}}"
                                           onclick="$('#day{{$day->sequence}}_trigger').trigger('click')">@svg('assets/more-images.svg',icon)
                                            <span>more images</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                        @endforeach
                        <div class="expendable">
                            <div class="title day" onclick="UI.expand(this)">
                                <div><span>Included</span></div>
                                @svg('assets/choose-month-arrow.svg','expand')
                            </div>
                            <div class="content day">
                                <div class="label">Welcome reception, dinner</div>
                                <div class="value">
                                    @if($itinerary->include_ship)
                                        <div class="included-section">

                                            <span>{{str_replace("\n"," | ",$itinerary->include_ship)}}</span>
                                        </div>
                                    @endif
                                    @if($itinerary->include_meal)
                                        <div class="included-section">

                                            <span>{{str_replace("\n"," | ",$itinerary->include_meal)}}</span>
                                        </div>
                                    @endif
                                    @if($itinerary->include_help)
                                        <div class="included-section">

                                            <span>{{str_replace("\n"," | ",$itinerary->include_help)}}</span>
                                        </div>
                                    @endif
                                    @if($itinerary->include_luggage)
                                        <div class="included-section">

                                            <span>{{str_replace("\n"," | ",$itinerary->include_luggage)}}</span>
                                        </div>
                                    @endif
                                    @if($itinerary->include_wifi)
                                        <div class="included-section">

                                            <span>{{str_replace("\n"," | ",$itinerary->include_wifi)}}</span>
                                        </div>
                                    @endif
                                    <div class="included-section">
                                        {!! $itinerary->include_note !!}
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>

                </div>
            @endforeach


    @endif





<div  class="new-page-wrapper">
    <div class="card ship">
        <div class="header">
            <div class="title title-inclusions-header">
                Inclusions
            </div>
        </div>
    <div id="inclusions" class="inclusions-section section">


        @if($itinerary->include_ship)
            <div class="inclusions-item">
                <div class="title-inclusions">
                    <label>@svg('assets/plus-circle.svg') <span>General</span></label>
                    <div class="line"></div>
                </div>

                <div class="details-inclusions">
                    <?php

                    $parts=explode("\n", $itinerary->include_ship);
                    ?>
                    @foreach($parts as $part)
                        @svg('assets/check-mark.svg') {{ $part }} <br>
                    @endforeach
                </div>
            </div>
        @endif

        @if($itinerary->include_meal)
            <div class="inclusions-item">
                <div class="title-inclusions">
                    <label>@svg('assets/spoon-fork.svg')<span> Food & Beverage</span></label>
                    <div class="line"></div>

                </div>

                <div class="details-inclusions">
                    <?php
                    $parts=explode("\n", $itinerary->include_meal);
                    ?>
                    @foreach($parts as $part)
                        @svg('assets/check-mark.svg') {{ $part }} <br>
                    @endforeach
                </div>
            </div>
        @endif

        @if($itinerary->include_service)
            <div class="inclusions-item">
                <div class="title-inclusions">
                    <label>@svg('assets/services.svg')<span> Service</span></label>
                    <div class="line"></div>

                </div>

                <div class="details-inclusions">
                    <?php
                    $parts=explode("\n", $itinerary->include_service);
                    ?>
                    @foreach($parts as $part)
                        @svg('assets/check-mark.svg') {{ $part }} <br>
                    @endforeach
                </div>
            </div>
        @endif

        @if($itinerary->include_excursions)
            <div class="inclusions-item">
                <div class="title-inclusions">
                    <label>@svg('assets/excursions.svg')<span> Excursions</span></label>
                    <div class="line"></div>

                </div>

                <div class="details-inclusions">
                    <?php
                    $parts=explode("\n", $itinerary->include_excursions);
                    ?>
                    @foreach($parts as $part)
                        @svg('assets/check-mark.svg') {{ $part }} <br>
                    @endforeach
                </div>
            </div>

        @endif

        @if($itinerary->not_include)
            <div class="inclusions-item">
                <div class="title-inclusions">
                    <label>@svg('assets/minus-circle.svg')<span> Price does not include</span></label>
                    <div class="line"></div>
                </div>
                <div class="details-inclusions">
                    <?php
                    $parts=explode("\n", $itinerary->not_include);
                    ?>
                    @foreach($parts as $part)
                        @svg('assets/red-x.svg') {{ $part }} <br>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    </div>
</div>

</div>
</body>
</html>
