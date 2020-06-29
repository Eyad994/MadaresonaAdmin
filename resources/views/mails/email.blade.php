@component('mail::message')
    Hello **{{$name}}**,  {{-- use double space for line break --}}

    Your password is **{{$password}}**,
    Sincerely,
    Madaresona team.
@endcomponent