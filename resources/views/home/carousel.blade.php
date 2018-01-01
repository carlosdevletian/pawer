<div id="landing-carousel" class="animated-background carousel slide" data-ride="carousel" style="min-height: 60vh">
    <ol class="carousel-indicators">
        @foreach($carouselImages as $image)
        <li data-target="#landing-carousel" data-slide-to="{{ $loop->index }}" class="{{ $loop->index === 0 ? 'active' : '' }} clickable"></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($carouselImages as $image)
        <div class="carousel-item {{ $loop->index === 0 ? 'active' : '' }}">
            <div class="background-image" style="background-image: url('{{ $image['absolute'] }}'); height: 60vh; width: 100vw" alt="Pawer Home Slide {{ $loop->index }}"></div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev opacity-3" href="#landing-carousel" role="button" data-slide="prev">
        @icon('arrow-left', 'icon-h-3 font-weight-bold')
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next opacity-3" href="#landing-carousel" role="button" data-slide="next">
        @icon('arrow-right', 'icon-h-3 font-weight-bold')
        <span class="sr-only">Next</span>
    </a>
</div>