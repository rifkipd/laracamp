@component('mail::message')
# Welcome

Hi, {{ $user->nama }} <br>
Welcome to laracamp , Your account has been registered on laracamp website <br>
Now you can choose ur favorite camp for study <br>
happy explore :)

@component('mail::button', ['url' => route('welcome')])
Login Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
