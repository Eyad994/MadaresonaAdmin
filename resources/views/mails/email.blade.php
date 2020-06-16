@component('mail::message')
    Hello **{{$name}}**,  {{-- use double space for line break --}}
    Thank you for choosing Mailtrap!

    Your password is **{{$password}}**,
    Sincerely,
    Madaresona team.
@endcomponent