<ul class="list_article_grid">
    @if ($articleList->isNotEmpty())
        @foreach ($articleList as $articleData)
            <li>
                <a href="{{ route('front.article.detail', ['article_id' => $articleData->id]) }}">
                    <div class="image_wrapper">
                        <img src="{{ $articleData->eyecatch }}">
                    </div>
                    <p>
                        {{ $articleData->title }}
                    </p>
                </a>
            </li>
        @endforeach
    @endif
</ul>