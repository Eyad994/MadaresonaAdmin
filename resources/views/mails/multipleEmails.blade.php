@component('mail::message')
    **{{$title}}**,

    {!! $subject !!} {{-- use double space for line break --}}
    Sincerely,
    Madaresona team.
@endcomponent