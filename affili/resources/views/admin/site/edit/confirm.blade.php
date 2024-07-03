@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/site.css') }}">
@endsection

@section('js')
@endsection

@section('content')
<div id="main">
    <section id="edit">
        <h2>{{ $pageName }}</h2>
        <div class="edit">
            <form method="POST" action="{{ route('administrator.site.edit.execution') }}">
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
                                {{ $inputData['name'] }}
                                <input type="hidden" name="name" value="{{ $inputData['name'] }}">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                ASP
                            </th>
                            <td class="">
                                @foreach ($platformList as $platformData)
                                    @if ($inputData['platform_id'] == $platformData->id)
                                        {{ $platformData->name }}
                                    @endif
                                @endforeach
                            </td>
                            <input type="hidden" name="platform_id" value="{{ $inputData['platform_id'] }}">
                        </tr>
                    </tbody>
                </table>

                <div class="table_separate"></div>

                <div class="button_area">
                    <button type="submit" name="action" value="submit">登録</button>
                    <button type="button" onClick="history.back();">フォームへ戻る</button>
                </div>
                <input type="hidden" name="id" value="{{ $inputData['id'] }}">
            </form>

        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection