<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<div class="swiper slider">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="https://placehold.jp/375x375.png"></div>
        <div class="swiper-slide"><img src="https://placehold.jp/3d4070/ffffff/375x375.png"></div>
        <div class="swiper-slide"><img src="https://placehold.jp/3e7046/ffffff/375x375.png"></div>
    </div>
    <div class="swiper-pagination"></div>
</div>
<script>
    const swiper = new Swiper('.slider', {
        loop: true, 
        autoplay: {
            delay: 4000,
        },
        centeredSlides : true,
        pagination: {
            el: '.swiper-pagination',
        },
    })
</script>
