@component('mail::message')

Witaj {{$user->name}},<br>
aby aktywować konto na {{ config('app.name') }} kliknij na poniższy przycisk

@component('mail::button', ['url' => route('confirmEmail',['confirm_code' => $user->confirm_code])])
Aktywuj konto
@endcomponent

Pozdrawiamy,<br>
{{ config('app.name') }}
@endcomponent
