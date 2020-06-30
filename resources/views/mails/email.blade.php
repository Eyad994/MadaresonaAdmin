@component('mail::message')
    Hello **{{$name}}**,  {{-- use double space for line break --}}

    Your password is ****,
    Sincerely,
    Madaresona team.
@endcomponent