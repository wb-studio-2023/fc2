@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/article.css') }}">
@endsection

@section('js')
<script src="{{ mix('js/admin/common.js') }}"></script>
<script src="{{ mix('js/admin/article.js') }}"></script>
@endsection

@section('component')
    <x-head.tinymce-config />
@endsection

@section('content')
<div id="main">
    <section id="regist">
        <h2>{{ $pageName }}</h2>
        <div class="regist">
            <form method="POST" action="{{ route('administrator.article.regist.confirm') }}" enctype="multipart/form-data">
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
                                サイト
                            </th>
                            <td colspan="6" class="">
                                <select name="site_id" class="width_max">
                                    @foreach ($siteList as $siteData)
                                        <option value="{{ $siteData->id }}"
                                            @if ( $siteData->id == old('site_id') )
                                                selected 
                                            @endif
                                        >
                                            {{ $siteData->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                動画ID
                            </th>
                            <td colspan="6">
                                <input type="text" name="movie_id" value="{{ old('movie_id') }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                女優
                            </th>
                            <td colspan="6" id="actress" class="open_block">
                                <div class="close">
                                    <p></p>
                                    <div class="opener">
                                        <img src="{{ mix('img/admin/plus.svg') }}">
                                    </div>
                                </div>
                                <div class="open">
                                    <div class="checkbox">
                                        @foreach ($actressList as $actressData)
                                            <label for="actress_{{ $actressData->id }}">
                                                <input type="checkbox" id="tag_{{ $actressData->id }}" value="{{ $actressData->id }}" name="actress[]"
                                                    @if ( !empty(old('actress')) && in_array($actressData->id, old('actress')) )
                                                        checked 
                                                    @endif
                                                >
                                                {{ $actressData->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="complete">
                                        <a>選択完了</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                タイトル
                            </th>
                            <td colspan="6">
                                <input type="text" name="title" value="{{ old('title') }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                見出し
                            </th>
                            <td colspan="6">
                                <input type="text" name="headline" value="{{ old('headline') }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">アイキャッチ</th>
                            <td colspan="6" class="image_area">
                                <label class="img" for="eyecatch">
                                    <input type="file" name="eyecatch" id="eyecatch">
                                    画像を選択
                                </label>
                                <p class="img_name">選択されていません</p>
                                <img id="thumb">
                                <input type="hidden" id="eyecatch_text" name="eyecatch_text" value="{{ old('eyecatch_text') }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                本文
                            </th>
                            <td colspan="6">
                                <textarea class="form-control" name="main" id="mainEditor">{{ old('main') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                カテゴリー
                            </th>
                            <td colspan="6" class="">
                                <select name="category" class="width_max">
                                    @foreach ($categoryList as $categoryData)
                                        <option value="{{ $categoryData->id }}"
                                            @if ( $categoryData->id == old('category') )
                                                selected 
                                            @endif
                                        >
                                            {{ $categoryData->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                タグ
                            </th>
                            <td colspan="6" id="tag" class="open_block">
                                <div class="close">
                                    <p></p>
                                    <div class="opener">
                                        <img src="{{ mix('img/admin/plus.svg') }}">
                                    </div>
                                </div>
                                <div class="open">
                                    <div class="checkbox">
                                        @foreach ($tagList as $tagData)
                                            <label for="tag_{{ $tagData->id }}">
                                                <input type="checkbox" id="tag_{{ $tagData->id }}" value="{{ $tagData->id }}" name="tag[]"
                                                    @if ( !empty(old('tag')) && in_array($tagData->id, old('tag')) )
                                                        checked 
                                                    @endif
                                                >
                                                {{ $tagData->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="complete">
                                        <a>選択完了</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                ステータス
                            </th>
                            <td>
                                <select name="status" class="width_max">
                                    @foreach ( config('const.ARTICLE.STATUS')  as $status)
                                        <option value="{{ $status['SEARCH_NUMBER'] }}"
                                            @if ( !empty(old('status')) && $status['SEARCH_NUMBER'] == old('status'))
                                                selected 
                                            @elseif ($status['SEARCH_NUMBER'] == config('const.ARTICLE.STATUS.PREPARATION.NUMBER'))
                                                selected
                                            @endif
                                        >
                                            {{ $status['NAME'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="return" value="on">
                <input type="hidden" name="return_flg" value="{{ old('return') }}">
                <input type="hidden" name="kind_flg" value="regist">
                <input type="hidden" name="view_type" value="form">
                <div class="table_separate"></div>

                <div class="button_area">
                    <button type="submit">確認画面へ</button>
                </div>
            </form>

        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection