<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    @stack('meta')

    @include('layouts.styles')
    @stack('styles')
</head>

<body>
    @includeWhen(!Auth::check(), 'modules.auth.index')
    @includeWhen(Auth::check(), 'modules.dashboard.index')

    @include('layouts.scripts')
    @stack('scripts')
</body>

</html>