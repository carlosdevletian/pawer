<form method="POST" action="{{ route('home-images.update') }}" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    <div id="landing-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#landing-carousel" data-slide-to="0" class="active clickable"></li>
            <li data-target="#landing-carousel" data-slide-to="1" class="clickable"></li>
            <li data-target="#landing-carousel" data-slide-to="2" class="clickable"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <input type="hidden" name="home_images[0]" value="{{isset($carouselImages[0]) ? $carouselImages[0]['relative'] : null}}">
                <image-upload file-name="home_images[0]"
                            :is-banner="false"
                            {{ isset($carouselImages[0]) ? "default-image={$carouselImages[0]['absolute']}" : '' }}
                            class="background-image"
                            style="width: 100vw; height: 60vh;"
                            alt="First Slide"></image-upload>
            </div>
            <div class="carousel-item">
                <input type="hidden" name="home_images[1]" value="{{isset($carouselImages[1]) ? $carouselImages[1]['relative'] : null}}">
                <image-upload file-name="home_images[1]"
                            :is-banner="false"
                            {{ isset($carouselImages[1]) ? "default-image={$carouselImages[1]['absolute']}" : '' }}
                            class="background-image"
                            style="width: 100vw; height: 60vh;"
                            :image-styles="{height: '60vh', width: '100vw'}"></image-upload>
            </div>
            <div class="carousel-item">
                <input type="hidden" name="home_images[2]" value="{{isset($carouselImages[2]) ? $carouselImages[2]['relative'] : null}}">
                <image-upload file-name="home_images[2]"
                            :is-banner="false"
                            {{ isset($carouselImages[2]) ? "default-image={$carouselImages[2]['absolute']}" : '' }}
                            class="background-image"
                            style="width: 100vw; height: 60vh;"
                            :image-styles="{height: '60vh', width: '100vw'}"></image-upload>
            </div>
        </div>
        <a class="carousel-control-prev opacity-3" href="#landing-carousel" role="button" data-slide="prev" style="z-index: 999">
            @icon('arrow-left', 'icon-h-3 font-weight-bold', ['style' => "background-color: transparent; filter: invert(100%);"])
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next opacity-3" href="#landing-carousel" role="button" data-slide="next" style="z-index: 999">
            @icon('arrow-right', 'icon-h-3 font-weight-bold', ['style' => "background-color: transparent; filter: invert(100%);"])
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="row justify-content-center bg-overlay">
        <button type="submit" class="btn btn-brand rounded-0 clickable">Save changes</button>
    </div>
</form>