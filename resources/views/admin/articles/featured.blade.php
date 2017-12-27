@if($article->isFeatured())
    <form class="d-inline-block" method="POST" action="{{ route('featured-articles.destroy') }}">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <button type="submit" class="btn clickable" title="This model is featured">@svg('bookmark', ['style' => "fill: red"])</button>
    </form>
@else
    <form class="d-inline-block" method="POST" action="{{ route('featured-articles.store') }}">
        {{ csrf_field() }}
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <button type="submit" class="btn clickable" title="This model is not featured">@svg('bookmark-outline-add', ['style' => "fill: red"])</button>
    </form>
@endif