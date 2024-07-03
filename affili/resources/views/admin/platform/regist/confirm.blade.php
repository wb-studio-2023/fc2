@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/platform.css') }}">
@endsection

@section('js')
@endsection

@section('content')
<div id="main">
    <section id="regist">
        <h2>{{ $pageName }}</h2>
        <div class="regist">
            <form method="POST" action="{{ route('administrator.platform.regist.execution') }}">
            @csrf
                <table>
                    <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 80%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>
                                カテゴリー名
                            </th>
                            <td>
                                {{ $inputData['name'] }}
                                <input type="hidden" name="name" value="{{ $inputData['name'] }}">
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