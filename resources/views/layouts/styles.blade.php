<link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
<link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">

@if(Auth::check())
<link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
<link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}">
@else
<link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
@endif
