@component('mail::message')
# Welcome {{ $client->name }},

Here is the latest Invoice.

@component('mail::panel')
The Invoice is attached.
@endcomponent

Have a nice day.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
