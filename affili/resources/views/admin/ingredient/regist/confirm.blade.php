@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/ingredient.css') }}">
@endsection

@section('js')
@endsection

@section('content')
<div id="main">
    <section id="regist">
        <h2>{{ $pageName }}</h2>
        <div class="regist">
            <form method="POST" action="{{ route('admin.ingredient.regist.execution') }}">
            @csrf
                <table>
                    <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 80%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>
                                材料名
                            </th>
                            <td>
                                {{ $inputData['title'] }}
                                <input type="hidden" name="title" value="{{ $inputData['title'] }}">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                効能・栄養
                            </th>
                            <td>
                                {!! nl2br(e($inputData['effect'])) !!}
                                <input type="hidden" name="effect" value="{{ $inputData['effect'] }}">
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