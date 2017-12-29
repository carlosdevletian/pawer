<div id="landing-carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#landing-carousel" data-slide-to="0" class="active clickable"></li>
        <li data-target="#landing-carousel" data-slide-to="1" class="clickable"></li>
        <li data-target="#landing-carousel" data-slide-to="2" class="clickable"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <image-upload file-name="home-carousel-images[]"
                        :is-banner="false"
                        class="background-image"
                        style="width: 100vw; height: 60vh;"
                        alt="First Slide"></image-upload>
        </div>
        <div class="carousel-item">
            <image-upload file-name="home-carousel-images[]"
                        :is-banner="false"
                        class="background-image"
                        style="width: 100vw; height: 60vh;"
                        :image-styles="{height: '60vh', width: '100vw'}"></image-upload>
        </div>
        <div class="carousel-item">
            <image-upload file-name="home-carousel-images[]"
                        :is-banner="false"
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