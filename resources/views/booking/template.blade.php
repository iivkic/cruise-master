@if(true)
    <p><strong>Inquiry: </strong>Cruise from {{$excursion->start->name}} to {{ $excursion->finish->name }}, MS {{ $excursion->ship->name }}</p>
    <p><strong>Date of departure: </strong>{{date_to_user($excursion->prices[0]->date)}}</p>
    @foreach(collect($excursion->prices)->unique('id') as $price)
        <p><strong>Number of {{ $price->room_type?$price->room_type->name:"" }}: </strong>{{ $price->people }} (<strong><?=show_currency_price($price->total, "price-data", "EUR")?></strong>)</p>

    @endforeach
    <p><strong>Total price of the trip: </strong><?=show_currency_price(collect($excursion->prices)->sum("total") , "price-data", "EUR")?></p>
    <p><a href="{{route("cruises.show",$excursion->slug)}}">Referral link</a></p>

    <p>Contact information:</p>
    <ul>
        <li>
            <strong>Name: </strong>{{ $title }} {{ $firstName }} {{ $lastName }}
        </li>
        <li>
            <strong>Email: </strong>{{ $email }}
        </li>
        @if($phone)
            <li>
                <strong>Phone: </strong>{{ $phone }}
            </li>
        @endif
        @if($country)
            <li>
                <strong>Country: </strong>{{ $country }}
            </li>
        @endif

        @if($user_message)
            <li>
                <strong>Message: </strong>{{ $user_message }}
            </li>
        @endif
    </ul>
    <br>

@endif
