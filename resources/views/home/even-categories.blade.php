@foreach($categories as $category)
    @include('home.half-width-category', ['category' => $category])
@endforeach
