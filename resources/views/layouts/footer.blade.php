<footer class="footer">
    <div class="container-fluid background-image" style="background-image: url('/images/footer-background.png');">
        <div class="row text-light p-4">
            <div class="col-md-6 col-lg-5 d-flex flex-column justify-content-center align-items-center">
                @svg('mono', 'icon-w-3 icon-h-3')
                <h5>SIGN UP TO BE IN THE KNOW</h5>
                <div class="d-flex form-group">
                    <input class="mr-2 form-control rounded-0 text-center" type="email" name="email" placeholder="Email address">
                    <button class="btn rounded-0 clickable btn-brand">Sign up</button>
                </div>
            </div>
            <div class="col-md-6 col-lg-7 d-none d-md-flex flex-column justify-content-center align-items-end">
                <p class="ls-1">
                    <a href="{{ route('about') }}" class="text-light fut-con-med" title="About Pawer">ABOUT-</a>
                </p>
                <p class="ls-1">
                    <a href="#" class="text-light fut-con-med" title="New Arrivals">NEW ARRIVALS-</a>
                </p>
                <p class="ls-1">
                    <a href="{{ route('catalog') }}" class="text-light fut-con-med" title="Catalog">CATALOG-</a>
                </p>
                @svg('logo', 'icon-h-2', ['style' => 'width: 20em'])
            </div>
        </div>
    </div>
</footer>