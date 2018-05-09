<a href="{{ route('products.index', $category->slug) }}" class="d-none d-md-block col-xs-12 w-100" title="{{ ucfirst($category->name) }}">
    <div class="p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('{{$category->getHomeImage()}}'); height: 33vh">
        <h4 class="display-4 mt-auto text-brand-primary font-italic pr-5 ml-sm-4 text-uppercase">_{{ $category->name }}</h4>
    </div>
</a>

<a href="{{ route('products.index', $category->slug) }}" class="d-md-none col-xs-12 w-100" title="{{ ucfirst($category->name) }}">
    <div class="p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('{{$category->getHomeImage()}}'); height: 55vh">
        @foreach($category->sub_names as $subName)
            @if($loop->first)
            <h4 class="display-4 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase">{{ $subName }}</h4>
            @else
            <h4 class="display-4 mt-0 text-brand-primary font-italic pr-5 ml-4 text-uppercase">{{ $loop->last ? "_{$subName}" : $subName }}</h4>
            @endif
        @endforeach
    </div>
</a>

