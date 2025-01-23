<h3>
    {{$subject}}
</h3>
<h4>Trip information:</h4>
<ul>
    <li><a href="{{route("cruises.show",$slug)}}">Referral link</a></li>
    <li>
        <b> Date of departure:</b> {{date_to_user($date)}}
    </li>
    <li>
        <b>Number of people:</b> {{$pax}}
    </li>
</ul>
<br>
<h4>Contact information:</h4>
<ul>
    <li>
        <b> Name:</b> {{ $name }}
    </li>
    <li>
        <b> Email:</b> {{ $email }}
    </li>
    <li>
        <b>Phone:</b> {{ $phone }}
    </li>
    <li>
        <b>Country:</b> {{ $country }}
    </li>
</ul>
<br>
<p>
    <b>Message:</b>
    <br>
    {{ $user_message }}
</p>

