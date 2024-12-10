<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->last)
                <!-- Dernier élément sans lien -->
                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
            @else
                <!-- Éléments avec liens -->
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>