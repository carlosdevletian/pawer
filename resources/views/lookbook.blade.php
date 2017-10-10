@extends('layouts.product-menu')

@section('main-content')
    <div class="container-fluid">
        <div class="row pt-4 pb-5 pl-5">
            <div class="col-12 pl-0">
                <small class="futura-medium" style="color: rgb(179,179,179)">SHOP > HEADWEAR > SNAPBACKS</small>
            </div>
        </div>
        <product-lookbook>
            <div slot="arrow-left">@icon('arrow-left', 'icon-h-3 font-weight-bold')</div>
            <div slot="arrow-right">@icon('arrow-right', 'icon-h-3 font-weight-bold')</div>
        </product-lookbook>
    </div>
@endsection
