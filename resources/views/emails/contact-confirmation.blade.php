<x-mail::message>
# Thank you for contacting us, {{ $contact->name }}

We have received your message and will get back to you soon.

Here’s what you submitted:

- **Interest:** {{ $contact->interest }}
- **Message:** {{ $contact->message }}

We appreciate your patience.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
