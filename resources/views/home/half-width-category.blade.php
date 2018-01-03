<a href="{{ route('products.index', $category->slug) }}" class="col-md-6 p-0 background-image d-flex flex-column {{ ($loop->index+2) %3 == 0 ? 'align-items-md-end' : 'align-items-start' }}" style="background-image: url('{{$category->getImage()}}'); height: 55vh" title="{{ ucfirst($category->name) }}">
    @foreach($category->sub_names as $subName)
        @if($loop->first)
            <h4 class="display-4 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase">{{ $subName }}</h4>
            @else
            <h4 class="display-4 mt-0 text-brand-primary font-italic pr-5 ml-4 text-uppercase">{{ $loop->last ? "_{$subName}" : $subName }}</h4>
            @endif
    @endforeach
</a>