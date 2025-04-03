<div class="col-12 col-md-6 order-md-2 order-first">
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            @foreach ($items as $item)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" {{ $loop->last ? 'aria-current=page' : '' }}>
                    @if (!$loop->last)
                        <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                    @else
                        {{ $item['name'] }}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>