This is an automated message.
A new contact form submission has been recieved at mycroatiacruise.com


<p>
    <b>Name:</b> {{ $name }}
</p>
<p>
    <b>Email:</b> {{ $email }}
</p>
<p>
    <b>Phone:</b> {{ $phone }}
</p>
@if(isset($date))
<p>
    <b>Date:</b> {{date_to_user($date)}}
</p>
@endif
@if(isset($duration))
    <p>
<p>
    <b>Duration:</b> {{ $duration }}
</p>
    @endif
@if(isset($pax))

<p>
    <b>Number of people:</b> {{ $pax }}
</p>
@endif
@if(isset($cabins))
<p>
    <b>Number of cabins:</b> {{ $cabins }}
</p>
@endif
<p>
    <b>Subject:</b> {{ $subject }}
</p>
<p>
    <b>Message:</b> {{ $user_message }}
</p>
