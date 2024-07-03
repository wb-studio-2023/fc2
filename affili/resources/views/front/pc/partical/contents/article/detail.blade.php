<div class="detail">
    <div class="explain">
        <div class="left">
            <img src="{{ $articleData['eyecatch'] }}">
        </div>
        <div class="right">
            <h3>
                {{ $articleData['title'] }}
            </h3>
            <div class="tag">
                @if (!is_null($articleData['tags'][0]->id))
                    @foreach ($articleData['tags'] as $articleTagData)
                        <a href="{{ route('front.tag.article.list', ['tag_id' => $articleTagData->id]) }}">{{ $articleTagData->name }}</a>
                    @endforeach
                @endif
            </div>
            <div class="affiliate_link">
                <a href="https://adult.contents.fc2.com/aff.php?aid={{ $articleData['movieId'] }}&affuid={{ config('const.AFFILIATE_ID.FC2') }}" target="_blank">この動画をもっと見る</a>
            </div>
        </div>
    </div>
    <div class="sample_movie">
        <div class="sample_movie_title">
            サンプル動画
        </div>
        <div class="movie">
            <iframe width="640" height="360" src="https://adult.contents.fc2.com/embed/{{ $articleData['movieId'] }}?i=TXprMU1UZ3lOamc9" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    <div class="sample_image">
        <div class="sample_image_title">
            サンプル動画
        </div>
        <div class="sample_image_image_area">
            <div class="sample_image_image">
                @if (!is_null($articleData['image'][0]))
                    @foreach ($articleData['image'] as $articleImageData)
                        <img src="{{ $articleImageData->path }}">
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="link">
        <a href="https://adult.contents.fc2.com/aff.php?aid={{ $articleData['movieId'] }}&affuid={{ config('const.AFFILIATE_ID.FC2') }}" target="_blank">この動画をもっと見る</a>
    </div>
</div>
