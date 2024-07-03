$(function() {
    let $tab = $('.tab'),
        $tabSelect = $tab.find('.select_tab'),
        $detailList = $('.detail_list'),
        $selectList = $detailList.find('.select_list');

    $('.select_tab').click(function () {
        // active削除
        $tabSelect.removeClass('active');
        $selectList.removeClass('active');

        // class選定
        let $className = $(this).attr('class'),
            $activeName = $className.split('_tab');

        // active付与
        $tab.find('.' + $activeName[0] + '_tab').addClass('active');
        $detailList.find('.' + $activeName[0] + '_list').addClass('active');
    })
});