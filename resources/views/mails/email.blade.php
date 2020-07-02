@component('mail::message')
    Hello **{{$name}}**,  {{-- use double space for line break --}}

    Your password is {{$password}}, {{-- use double space for line break --}}
    Sincerely,
    Madaresona team.
@endcomponent