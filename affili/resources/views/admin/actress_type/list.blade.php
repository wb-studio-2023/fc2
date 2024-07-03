@extends('admin.layout')

@section('title')
【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/actress_type.css') }}">
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
                <a href="{{ route('administrator.actress_type.regist.showForm') }}">
                    +新規登録
                </a>
            </div>
            <div class="form">
                <form method="POST" name="{{ route('administrator.actress_type.search') }}">
                @csrf
                    <input type="text" name="keyword" value="{{ $arrayRequest['keyword'] }}">
                    <button type="submit">検索</button>
                    <a href="{{ route('administrator.actress_type.list') }}" name="cancel">検索解除</a>
                </form>
            </div>
        </div>
        <div class="list_area">
            @if ($actressTypeList->isNotEmpty())
                <form method="POST" action="{{ route('administrator.actress_type.delete.execution') }}">
                @csrf
                    <table>
                        <colgroup>
                            <col style="width: 8%;">
                            <col style="width: 44%;">
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
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'id', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'id' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'id', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    名前<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'name' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'name', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'name' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'name', 'st' => 'd']) }}">
                                            &#9660;
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    登録日時<br>
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'created_at' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'u' )
                                        <span class="search_now">
                                            &#9650;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'created_at', 'st' => 'u']) }}">
                                            &#9650;
                                        </span>
                                    @endif
                                    @if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] == 'created_at' && isset($arrayRequest['st']) && $arrayRequest['st'] == 'd' )
                                        <span class="search_now">
                                            &#9660;
                                        </a>
                                    @else
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'created_at', 'st' => 'd']) }}">
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
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'updated_at', 'st' => 'u']) }}">
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
                                        <a href="{{ route('administrator.actress_type.list', ['keyword' => $arrayRequest['keyword'], 'sk' => 'updated_at', 'st' => 'd']) }}">
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
                            @foreach ($actressTypeList as $actressTypeData)
                                <tr>
                                    <td>
                                        <a href="{{ route('administrator.actress_type.edit.showForm', ['actress_type_id' => $actressTypeData->id]) }}">
                                            {{ $actressTypeData->id }}
                                        </a>
                                    </td>
                                    <td class="left">
                                        <a href="{{ route('administrator.actress_type.edit.showForm', ['actress_type_id' => $actressTypeData->id]) }}">
                                            {{ $actressTypeData->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ Common::dateConverter($actressTypeData->created_at) }}<br>
                                        {{ Common::timeConverter($actressTypeData->created_at) }}
                                    </td>
                                    <td>
                                        {{ Common::dateConverter($actressTypeData->updated_at) }}<br>
                                        {{ Common::timeConverter($actressTypeData->updated_at) }}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="delete[]" value="{{ $actressTypeData->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="table_separate"></div>
                    <div id="pagination">
                        {{ $actressTypeList->appends($arrayRequest)->links('admin.partical.pagination') }}
                    </div>

                    <div class="button_area">
                        <button type="submit">checkしたものを削除する</button>
                    </div>
                </form>
            @else
                <div>登録されている食材はありません。</div>
            @endif
        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection