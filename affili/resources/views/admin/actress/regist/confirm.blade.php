@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/actress_type.css') }}" enctype="multipart/form-data">
@endsection

@section('js')
<script src="{{ mix('js/admin/common.js') }}"></script>
@endsection

@section('content')
<div id="main">
    <section id="regist">
        <h2>{{ $pageName }}</h2>
        <div class="regist">
            <form method="POST" action="{{ route('administrator.actress.regist.execution') }}">
            @csrf
                <table>
                    <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 80%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>
                                女優名
                            </th>
                            <td>
                                {{ $inputData['name'] }}
                                <input type="hidden" name="name" value="{{ $inputData['name'] }}">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                かな
                            </th>
                            <td>
                                {{ $inputData['name_kana'] }}
                                <input type="hidden" name="name_kana" value="{{ $inputData['name_kana'] }}">
                            </td>
                        </tr>
                        <tr>
                            <th>アイキャッチ</th>
                            <td>
                                @if (!empty($inputData['eyecatch']))
                                    <img id="thumb_confirm" src="{{ $eyecatchUrl }}">
                                @endif
                                <input type="hidden" name="eyecatch" value="{{ $eyecatchUrl }}">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                サイズ
                            </th>
                            <td>
                                {{ $inputData['size'] }}
                                <input type="hidden" name="size" value="{{ $inputData['size'] }}">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                タイプ
                            </th>
                            <td>
                                @if (!empty($inputData['actress_type']))
                                    @foreach ($inputData['actress_type'] as $actressType)
                                        @foreach ($actressTypeList as $actressTypeData)
                                            @if ($actressType == $actressTypeData->id)
                                                {{ $actressTypeData->name }}
                                            @endif
                                        @endforeach
                                        @if (!$loop->last)
                                            <span>、</span>
                                        @endif
                                    @endforeach
                                @endif
                                @if (!empty($inputData['actress_type']))
                                    @foreach ($inputData['actress_type'] as $actressType)
                                        <input type="hidden" name="actress_type[]" value="{{ $actressType }}">
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                紹介
                            </th>
                            <td>
                                {{ $inputData['introduction'] }}
                                <input type="hidden" name="introduction" value="{{ $inputData['introduction'] }}">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table_separate"></div>

                <div class="button_area">
                    <button type="submit" name="action" value="submit">登録</button>
                    <button type="button" onClick="history.back();">フォームへ戻る</button>
                </div>
            </form>

        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection