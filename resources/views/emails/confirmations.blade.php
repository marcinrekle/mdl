Witaj {{ $user->name }},< /br>
kliknij w poniższy link aby potwierdzić adres email oraz aktywować konto na <a href="{{ config('app.url') }}"> {{ config('app.name') }} </a>
< /br>
<a href="{{ route('confirmEmail') }}">Potwierdż adres E-mail</a>

