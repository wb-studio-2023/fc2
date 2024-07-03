$(function() {
    /** 
     * ヘッダーの開閉
    */
    const header = $('header');
    let prevY = $(window).scrollTop();

    $(window).scroll(() => {
        const currentY = $(window).scrollTop();

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