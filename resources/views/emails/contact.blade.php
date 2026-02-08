<x-mail::message>
# New Contact Form Submission

- **Name:** {{ $contact->name }}
- **Email:** {{ $contact->email }}
- **Phone:** {{ $contact->phone_number }}
- **Country:** {{ $contact->country_name }} ({{ $contact->country_iso }})
- **Interest:** {{ $contact->interest }}
- **Message:** {{ $contact->message }}

@if($contact->has_whatsapp)
- WhatsApp available
@endif

@if($contact->has_telegram)
- Telegram: {{ $contact->telegram_username }}
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
