@component('mail::message')
    Hello **{{$name}}**,  {{-- use double space for line break --}}

<<<<<<< HEAD
    Your password is **{{ $password }}**,
=======
    Your password is **{{$password}}**,
>>>>>>> aa1e115cee41c9a553fb37ae58722505a583bfbe
    Sincerely,
    Madaresona team.
@endcomponent