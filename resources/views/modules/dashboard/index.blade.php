<div class="app">
    <x-layouts.sidebar :menus="[
        ['title' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'bi bi-grid-fill'],
        ['title' => 'Home Section', 'route' => 'dashboard/home', 'icon' => 'bi bi-house-door-fill'],
        ['title' => 'About Section', 'route' => 'dashboard/about', 'icon' => 'bi bi-book-fill'],
        ['title' => 'Team Section', 'route' => 'dashboard/team', 'icon' => 'bi bi-person-lines-fill'],
        ['title' => 'Signature Section', 'route' => 'dashboard/signature', 'icon' => 'bi bi-hand-thumbs-up-fill'],
        ['title' => 'Menu Section', 'route' => 'dashboard/menu', 'icon' => 'bi bi-menu-button-fill'],
        [
            'title' => 'Today Menu Section', 
            'route' => 'dashboard/today-menu', 
            'icon' => 'bi bi-menu-up',
            'submenus' => [
                ['title' => 'Category', 'route' => 'dashboard/today-menu/categories'],
                ['title' => 'Today Menu', 'route' => 'dashboard/today-menu'],
            ]
        ],
        ['title' => 'Footer Section', 'route' => 'dashboard/footer', 'icon' => 'bi bi-microsoft'],
    ]" />

    <div id="main" class="layout-navbar navbar-fixed">
        @include('layouts.header')
    
        <div id="main-content">
            @yield('content')
        </div>
    
        @include('layouts.footer')
    </div>
</div>