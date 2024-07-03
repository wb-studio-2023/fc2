@extends('admin.layout')

@section('title')
【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/article.css') }}">
@endsection

@section('js')
<script src="{{ mix('js/admin/common.js') }}"></script>
@endsection

@section('content')
<div id="main">
    <section id="list">
        <h2>{{ $pageName }}</h2>
        <div class="query_area">
            <div class="create">
                <a href="{{ route('administrator.article.regist.showForm') }}">
                    +新規登録
                </a>
            </div>
            <div class="form">
                <form method="POST" name="{{ route('administrator.article.search') }}">
                @csrf
                    <div class="search_input_area">
                        <div class="checkbox_area">
                            @foreach ( config('const.ARTICLE.STATUS') as $key => $status)
                                <label for="status_{{ $status['SEARCH_NUMBER'] }}">
                                    <input type="checkbox" id="status_{{ $status['SEARCH_NUMBER'] }}" name="status[]" value="{{ $status['SEARCH_NUMBER'] }}"
                                        @if ( !empty($convertRequest['status']) && in_array($status['SEARCH_NUMBER'], $convertRequest['status']) )
                                            checked
                                        @endif 
                                    >
                                    {{ $status['NAME'] }}
                                </label>
                            @endforeach
                        </div>
                        <div class="text_area">
                            <input type="text" name="keyword" value="{{ $arrayRequest['keyword'] }}">
                        </div>
                    </div>
                    <div class="search_button_area">
                        <button type="submit">検索</button>
                        <a href="{{ route('administrator.article.list') }}" name="cancel">検索解除</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="list_area">
            @if ($articleList->isNotEmpty())
                <form method="POST" action="{{ route('administrator.article.delete.execution') }}">
                @csrf
                    <div class="total">
                        {{ $articleList->firstItem() }}件～{{ $articleList->lastItem() }}件を表示(全{{ $articleList->total() }}件)
                    <table>
                        <colgroup>
                            <col style="width: 8%;">
                            <col style="width: 9%;">
                            <col style="width: 44%;">
                            <col style="width: 9%;">
                            <col style="width: 9%;">
                            <col style="width: 9%;">
                            <col style="width: 9%;">
                            <col style="width: 3%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <td>
                                    ID<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'id' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'id', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'id' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'id', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    ステータス
                                </td>
                                <td>
                                    タイトル<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'title' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'title', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'title' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'title', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    イイねの数<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'like' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'like', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'like' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'like', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    閲覧数<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'watch' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'watch', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'watch' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'watch', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    公開日時<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'release_at' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'release_at', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'release_at' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'release_at', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    更新日時<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'updated_at' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'updated_at', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( (isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'updated_at' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd')
                                        || ( !isset($arrayRequest['sk']) && !isset($arrayRequest['st']))
                                    )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.article.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'updated_at', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    削除
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articleList as $articleData)
                                <tr>
                                    <td>
                                        <a href="{{ route('administrator.article.edit.showForm', ['article_id' => $articleData->id]) }}">
                                            {{ $articleData->id }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ Common::statusConverter($articleData->status, $articleData->release_at) }}
                                    </td>
                                    <td class="left">
                                        <a href="{{ route('administrator.article.edit.showForm', ['article_id' => $articleData->id]) }}">
                                            {{ $articleData->title }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $articleData->like }}
                                    </td>
                                    <td>
                                        {{ $articleData->watch }}
                                    </td>
                                    <td>
                                        {{ Common::dateConverter($articleData->release_at) }}<br>
                                        {{ Common::timeConverter($articleData->release_at) }}
                                    </td>
                                    <td>
                                        {{ Common::dateConverter($articleData->updated_at) }}<br>
                                        {{ Common::timeConverter($articleData->updated_at) }}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="delete[]" value="{{ $articleData->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="table_separate"></div>
                    <div id="pagination">
                        {{ $articleList->links('admin.partical.pagination') }}
                    </div>

                    <div class="button_area">
                        <button type="submit">checkしたものを削除する</button>
                    </div>
                </form>
            @else
                <div>登録されているカテゴリーはありません。</div>
            @endif
        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection