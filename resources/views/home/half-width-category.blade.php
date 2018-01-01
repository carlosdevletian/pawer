<a href="{{ route('products.index', $category->slug) }}" class="col-md-6 p-0 background-image d-flex flex-column {{ ($loop->index+2) %3 == 0 ? 'align-items-md-end' : 'align-items-start' }}" style="background-image: url('{{$category->getImage()}}'); height: 55vh">
    <h2 class="display-4 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase">_{{ $category->name }}</h2>
</a>