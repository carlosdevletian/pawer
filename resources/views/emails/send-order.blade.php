<div style="background-color: #22292f; height: 100%; padding: 15px; color: white; overflow:scroll;">
    <div style="text-align: center">
        @svg('logo', ['style' => 'width: 150px;'])
    </div>

    <h2>A client has made an order</h2>

    <h4><a style="color: #b3b3b3;" href="mailto:{{ $emailAddress }}">Contact them</a> or reply to this email</h4>

    <div style="width:100%; text-align: right">Order total: ${{ $items->sum('total_price') }}</div>

    <div style="padding: 5px">
        @foreach($items as $item)
            <div style=" background-color: white; color: #22292f; padding: 15px; margin-bottom: 15px">
                <img height="75px" width="75px" src="{{ asset($item->article->main_image_path) }}" style="float:left; margin-right: 10px">
                <div>
                    <div>Product: <a href="{{ route('articles.show', $item->article->slug) }}">{{ $item->article->name }}</a></div>
                    <div>Color: {{ $item->article->color_name }}</div>
                    <div>Quantity: {{ $item->quantity }}</div>
                    <div>Total price: ${{ $item->total_price }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>