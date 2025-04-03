<div class="app">
    <x-layouts.sidebar :menus="[
        ['title' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'bi bi-grid-fill'],
        ['title' => 'Home Section', 'route' => 'dashboard/home', 'icon' => 'bi bi-house-door-fill'],
        ['title' => 'About Section', 'route' => 'dashboard/about', 'icon' => 'bi bi-book-fill'],
        ['title' => 'Signature Section', 'route' => 'dashboard/signature', 'icon' => 'bi bi-hand-thumbs-up-fill'],
        ['title' => 'Menu Section', 'route' => 'menu', 'icon' => 'bi bi-menu-button-fill'],
    ]" />

    <div id="main" class="layout-navbar navbar-fixed">
        @include('layouts.header')
    
        <div id="main-content">
            @yield('content')
        </div>
    
        @include('layouts.footer')
    </div>
</div>