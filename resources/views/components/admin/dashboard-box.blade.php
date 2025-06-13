@props(['count', 'label', 'icon', 'route', 'color'])

<div class="col-lg-3 col-6">
    <div class="small-box {{ $color }}">
        <div class="inner">
            <h3>{{ $count }}</h3>
            <p>{{ $label }}</p>
        </div>
        <div class="icon">
            <i class="fas {{ $icon }}"></i>
        </div>
        <a href="{{ route($route) }}" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
