<div id=sidenavi class="content">
    <div class="logo_area">
        <img src="{{ mix('img/admin/logoMark.png') }}" class="logo">
    </div>
    <ul>
        <a href="{{ route('administrator.dashboard') }}"><li>HOME</li></a>
        <a href="{{ route('administrator.article.list') }}" class="unsetting"><li>記事</li></a>
        <a href="{{ route('administrator.actress.list') }}" class="unsetting"><li>女優</li></a>
        <a href="{{ route('administrator.actress_type.list') }}" class="unsetting"><li>女優タイプ</li></a>
        <a href="{{ route('administrator.category.list') }}" class="unsetting"><li>カテゴリー</li></a>
        <a href="{{ route('administrator.tag.list') }}" class="unsetting"><li>タグ</li></a>
        <a href="{{ route('administrator.platform.list') }}" class="unsetting"><li>プラットフォーム</li></a>
        <a href="{{ route('administrator.site.list') }}" class="unsetting"><li>サイト</li></a>
        <a href="{{ route('administrator.logout') }}" class="unsetting"><li>ログアウト</li></a>
    </ul>
</div>
