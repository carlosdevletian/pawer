<nav aria-label="breadcrumb" role="navigation" >
    <ol class="breadcrumb bg-transparent pl-5 pt-0 m-0">
         @foreach($links as $name => $link)
            @if($name === 'active')
                <li class="breadcrumb-item active" aria-current="page">
                    <small class="futura-medium text-dark text-uppercase">{{ $link }}</small>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $link }}">
                        <small class="futura-medium text-grey text-uppercase">{{ $name }}</small>
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
