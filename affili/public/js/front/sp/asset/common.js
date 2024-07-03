$(function () {
  /** 
   * ヘッダーの開閉
  */
  var header = $('header');
  var prevY = $(window).scrollTop();
  $(window).scroll(function () {
    var currentY = $(window).scrollTop();
    if (currentY < prevY) {
      header.removeClass('hidden');
    } else {
      if (currentY > 0) {
        header.addClass('hidden');
      }
    }
    prevY = currentY;
  });

  /** 
   * ナビゲーションメニューの開閉
  */
  $("#menu .open").click(function () {
    $(this).toggleClass('active');
    $("#menu .nav").toggleClass('panelactive');
  });
  $("#menu .nav a").click(function () {
    $("#menu .open").removeClass('active');
    $("#menu .nav").removeClass('panelactive');
  });
});
