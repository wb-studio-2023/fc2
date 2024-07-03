<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<div class="swiper slider">
    <div class="swiper-wrapper">
        @foreach ($slideArticleList as $slideArticleData)
            <div class="swiper-slide">
                <a href="{{ route('front.article.detail', ['article_id' => $slideArticleData->id]) }}">
                    <div class="items_article_MainitemThumb">
                        <span>
                            <img src="{{ $slideArticleData->eyecatch }}">
                        </span>
                    </div>
                    <p>
                        {{ $slideArticleData->title }}
                    </p>
                </a>
            </div>
        @endforeach
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<script>
    const swiper = new Swiper('.slider', {
        loop: true, 
        // autoplay: {
        //     delay: 4000,
        // },
        centeredSlides : true,
        pagination: {
            el: '.swiper-pagination',
        },
          // 前後の矢印
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    })
</script>
