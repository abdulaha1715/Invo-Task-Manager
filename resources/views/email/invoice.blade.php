@component('mail::message')
# Welcome

The body of your message.

@component('mail::panel')
The Invoice is attached.
@endcomponent

Have a nice day.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
