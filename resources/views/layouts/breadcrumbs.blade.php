<div class="row pt-4 pb-5 pl-5">
    <div class="col-12 pl-0">
        <nav aria-label="breadcrumb" role="navigation" >
            <ol class="breadcrumb bg-transparent pl-0 pt-0">
                 @foreach($links as $name => $link)
                    @if($name === 'active')
                        <li class="breadcrumb-item active" aria-current="page">
                            <small class="futura-medium text-dark text-uppercase">{{ ($link) }}</small>
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $link }}" title="{{ ucfirst($name) }}">
                                <small class="futura-medium text-grey text-uppercase">{{ ($name) }}</small>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>