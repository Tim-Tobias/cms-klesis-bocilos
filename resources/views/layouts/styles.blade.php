<link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">

@if(Auth::check())
<link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
@else
<link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
@endif
