<a href="{{ route('products.index', $category->slug) }}" class="d-none d-md-block col-xs-12 w-100">
    <div class="p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('{{$category->getImage()}}'); height: 33vh">
        <h1 class="display-4 mt-auto text-brand-primary font-italic pr-5 ml-sm-4 text-uppercase">_{{ $category->name }}</h1>
    </div>
</a>

<a href="{{ route('products.index', $category->slug) }}" class="d-md-none col-xs-12 w-100">
    <div class="p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('{{$category->getImage()}}'); height: 55vh">
        <h1 class="display-4 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-sm-4 text-uppercase">{{ $category->name }}</h1>
        <h1 class="display-4 mt-0 text-brand-primary font-italic pr-5 ml-sm-4 text-uppercase">{{ $category->name }}</h1>
    </div>
</a>

