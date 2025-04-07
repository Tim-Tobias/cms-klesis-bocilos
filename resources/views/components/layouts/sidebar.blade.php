<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('LOGO PUTIH.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                @foreach ($menus as $menu)
                    @if(isset($menu['submenus']))
                    <li class="sidebar-item has-sub {{ request()->is($menu['route'] . '/*') || request()->is($menu['route'])  ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="{{$menu['icon']}}"></i>
                            <span>{{ $menu['title'] }}</span>
                        </a>
                        
                        <ul class="submenu {{ request()->is($menu['route'] . "/*") || request()->is($menu['route']) ? 'active submenu-open' : '' }}">
                            @foreach($menu['submenus'] as $submenu)
                            <li class="submenu-item {{ request()->is($submenu["route"]) ? 'active' : '' }}">
                                <a href="{{ url($submenu['route']) }}" class="submenu-link">{{ $submenu['title'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li class="sidebar-item {{ request()->is($menu['route']) ? 'active' : '' }}">
                        <a href="{{ url($menu['route']) }}" class="sidebar-link">
                            <i class="{{ $menu['icon'] }}"></i>
                            <span>{{ $menu['title'] }}</span>
                        </a>
                    </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
</div>
