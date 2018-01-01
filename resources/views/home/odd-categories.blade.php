@foreach($categories as $category)
    @if(($loop->index+1) %3 == 0)
        @include('home.full-width-category', ['category' => $category])
    @else
        @include('home.half-width-category', ['category' => $category])
    @endif
@endforeach
