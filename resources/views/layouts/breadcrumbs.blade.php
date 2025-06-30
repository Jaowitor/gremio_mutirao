<div class="breadcrumbs-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb-geo">
            @foreach ($breadcrumbs_list ?? [] as $breadcrumb)
                <li class="{{ $loop->last ? 'active' : '' }}">
                    <a href="{{ $breadcrumb['url'] }}">
                        {{ $breadcrumb['name'] }}
                    </a>
                </li>
            @endforeach
        </ol>
    </nav>
</div>