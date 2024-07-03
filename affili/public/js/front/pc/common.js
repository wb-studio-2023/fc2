$(function () {
  // slider
  setTimeout(function () {
    $sliderWrapper = $('.swiper-wrapper');
    $sliderImages = $sliderWrapper.find('img');
    $sliderImages.each(function (index, elem) {
      var $elem = $(elem),
        elemWidth = $elem.width(),
        elemHeight = $elem.height();
      if (elemWidth < elemHeight) {
        $elem.css('height', '100%');
      } else {
        $elem.css('width', '100%');
      }
    });
  }, 500);
});
