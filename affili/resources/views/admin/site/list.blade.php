@extends('admin.layout')

@section('title')
【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/site.css') }}">
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
                <a href="{{ route('administrator.site.regist.showForm') }}">
                    +新規登録
                </a>
            </div>
        </div>
        <div class="list_area">
            @if ($siteList->isNotEmpty())
                <form method="POST" action="{{ route('administrator.site.delete.execution') }}">
                @csrf
                    <table>
                        <colgroup>
                            <col style="width: 8%;">
                            <col style="width: 40%;">
                            <col style="width: 31%;">
                            <col style="width: 9%;">
                            <col style="width: 9%;">
                            <col style="width: 3%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <td>
                                    ID
                                </td>
                                <td>
                                    名前
                                </td>
                                <td>
                                    プラットフォーム(ASP)
                                </td>
                                <td>
                                    登録日時
                                </td>
                                <td>
                                    更新日時
                                </td>
                                <td>
                                    削除
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siteList as $siteData)
                                <tr>
                                    <td>
                                        <a href="{{ route('administrator.site.edit.showForm', ['site_id' => $siteData->id]) }}">
                                            {{ $siteData->id }}
                                        </a>
                                    </td>
                                    <td class="left">
                                        <a href="{{ route('administrator.site.edit.showForm', ['site_id' => $siteData->id]) }}">
                                            {{ $siteData->name }}
                                        </a>
                                    </td>
                                    <td class="left">
                                        {{ $siteData->platform_name }}
                                    </td>
                                    <td>
                                        {{ Common::dateConverter($siteData->created_at) }}<br>
                                        {{ Common::timeConverter($siteData->created_at) }}
                                    </td>
                                    <td>
                                        {{ Common::dateConverter($siteData->updated_at) }}<br>
                                        {{ Common::timeConverter($siteData->updated_at) }}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="delete[]" value="{{ $siteData->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="table_separate"></div>
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