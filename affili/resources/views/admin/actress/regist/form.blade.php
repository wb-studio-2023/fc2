@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/actress.css') }}">
@endsection

@section('js')
<script src="{{ mix('js/admin/common.js') }}"></script>
@endsection

@section('content')
<div id="main">
    <section id="regist">
        <h2>{{ $pageName }}</h2>
        <div class="regist">
            <form method="POST" action="{{ route('administrator.actress.regist.confirm') }}" enctype="multipart/form-data">
            @csrf
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="validation">※{{ $error }}</p>
                    @endforeach
                @endif
                <table>
                    <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 80%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>
                                名前
                            </th>
                            <td>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                カナ
                            </th>
                            <td>
                                <input type="text" name="name_kana" value="{{ old('name_kana') }}">
                            </td>
                        </tr>
                        <tr>
                            <th>アイキャッチ</th>
                            <td class="image_area">
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
                            <th>
                                サイズ
                            </th>
                            <td>
                                <select name="size" class="size">
                                    <option></option>
                                    @foreach (config('const.ACTRESS.SIZE') as $size)
                                        <option value="{{ $size }}"
                                            @if ( $size == old('size') )
                                                selected 
                                            @endif
                                        >
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                                カップ
                            </td>
                        </tr>
                        <tr>
                            <th>
                                女優タイプ
                            </th>
                            <td id="actress_type" class="open_block">
                                @if (!is_null($actressTypeList))
                                    <div class="close">
                                        <p></p>
                                        <div class="opener">
                                            <img src="{{ mix('img/admin/plus.svg') }}">
                                        </div>
                                    </div>
                                    <div class="open">
                                        <div class="checkbox">
                                            @foreach ($actressTypeList as $actressTypeData)
                                                <label for="actress_type_{{ $actressTypeData->id }}">
                                                    <input type="checkbox" id="actress_type_{{ $actressTypeData->id }}" value="{{ $actressTypeData->id }}" name="actress_type[]"
                                                        @if ( !empty(old('actress_type')) && in_array($actressTypeData->id, old('actress_type')) )
                                                            checked 
                                                        @endif
                                                    >
                                                    {{ $actressTypeData->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="complete">
                                            <a>選択完了</a>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                紹介
                            </th>
                            <td>
                                <textarea name="introduction">{{ old('introduction') }}</textarea>
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