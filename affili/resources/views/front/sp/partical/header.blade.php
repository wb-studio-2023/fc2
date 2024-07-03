<div>
    <div class="header_upper">
        <div class="header_upper_left">
            <a href="">
                <img src="{{ mix('img/front/sp/logo_mark_test.png') }}" class="logo_mark">
                <img src="{{ mix('img/front/sp/logo_type_test.png') }}" class="logo_type">
            </a>
        </div>
        <div class="header_upper_right">
            <a href="">
                <img src="{{ mix('img/front/sp/login.svg') }}" class="login">
                <span>ログイン</span>
            </a>
            <span class="span_mune">メニュー</span>
        </div>
    </div>

    <div class="header_downner">
        <form action="" method="">
            <input type="text" name="" placeholder="料理名、食材を入力">
            <button type="submit">
                <img src="{{ mix('img/front/sp/search.svg') }}" class="search">
            </button>
        </form>
        <div class="detailed_search">
            @include('front.sp.partical.detailed_search')
            <label for="trigger" class="open">詳細検索</label>
        </div>
    </div>
</div>