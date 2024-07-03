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
    <section id="edit">
        <h2>{{ $pageName }}</h2>
        <div class="edit">
            <form method="POST" action="{{ route('administrator.article.edit.execution') }}">
            @csrf
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="validation">※{{ $error }}</p>
                    @endforeach
                @endif
                <table>
                    <colgroup>
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th colspan="2">
                                カテゴリー
                            </th>
                            <td colspan="6" class="">
                                @foreach ($siteList as $siteData)
                                    @if ($inputData['site_id'] == $siteData->id)
                                        {{ $siteData->name }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                動画ID
                            </th>
                            <td colspan="6">
                                {{ $inputData['movie_id'] }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                女優
                            </th>
                            <td colspan="6">
                                @if (!empty($inputData['actress']))
                                    @foreach ($inputData['actress'] as $actress)
                                        @foreach ($actressList as $actressData)
                                            @if ($actress == $actressData->id)
                                                {{ $actressData->name }}
                                            @endif
                                        @endforeach
                                        @if (!$loop->last)
                                            <span>、</span>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                タイトル
                            </th>
                            <td colspan="6">
                                {{ $inputData['title'] }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                見出し
                            </th>
                            <td colspan="6">
                                {{ $inputData['headline'] }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">アイキャッチ</th>
                            <td colspan="6">
                                @if (!empty($inputData['eyecatch']))
                                    <img id="thumb_confirm" src="{{ $eyecatchUrl }}">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                本文
                            </th>
                            <td colspan="6" class="td_main">
                                {!! $inputData['main'] !!}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                カテゴリー
                            </th>
                            <td colspan="6" class="">
                                @foreach ($categoryList as $categoryData)
                                    @if ($inputData['category'] == $categoryData->id)
                                        {{ $categoryData->name }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                タグ
                            </th>
                            <td colspan="6">
                                @if (!empty($inputData['tag']))
                                    @foreach ($inputData['tag'] as $tag)
                                        @foreach ($tagList as $tagData)
                                            @if ($tag == $tagData->id)
                                                {{ $tagData->name }}
                                            @endif
                                        @endforeach
                                        @if (!$loop->last)
                                            <span>、</span>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                ステータス
                            </th>
                            <td>
                                @foreach (config('const.ARTICLE.STATUS') as $configStatus)
                                    @if ($inputData['status'] == $configStatus['SEARCH_NUMBER'])
                                        {{ $configStatus['NAME'] }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="id" value="{{ $inputData['id'] }}">
                <input type="hidden" name="movie_id" value="{{ $inputData['movie_id'] }}">
                <input type="hidden" name="site_id" value="{{ $inputData['site_id'] }}">
                <input type="hidden" name="title" value="{{ $inputData['title'] }}">
                <input type="hidden" name="headline" value="{{ $inputData['headline'] }}">
                <input type="hidden" name="eyecatch" value="{{ $eyecatchUrl }}">
                <input type="hidden" name="main" value="{{ $inputData['main'] }}">
                <input type="hidden" name="category" value="{{ $inputData['category'] }}">
                <input type="hidden" name="status" value="{{ $inputData['status'] }}">
                <input type="hidden" name="return" value="on">
                <input type="hidden" name="return_flg" value="on">
                <input type="hidden" name="kind_flg" value="edit">
                @if (!empty($inputData['actress']))
                    @foreach ($inputData['actress'] as $actress)
                        <input type="hidden" name="actress[]" value="{{ $actress }}">
                    @endforeach
                @endif
                @if (!empty($inputData['tag']))
                    @foreach ($inputData['tag'] as $tag)
                        <input type="hidden" name="tag[]" value="{{ $tag }}">
                    @endforeach
                @endif

                <div class="table_separate"></div>

                <div class="button_area">
                    <button type="submit" name="action" value="submit" class="action">登録</button>
                    <button type="button" onClick="history.back();">フォームへ戻る</button>
                </div>
            </form>

        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection