@extends('admin.layout')

@section('title')
    【eM管理画面】{{ $pageName }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ mix('css/admin/actress_type.css') }}">
@endsection

@section('js')
@endsection

@section('content')
<div id="main">
    <section id="regist">
        <h2>{{ $pageName }}</h2>
        <div class="regist">
            <form method="POST" action="{{ route('administrator.actress_type.regist.confirm') }}">
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
                                材料名
                            </th>
                            <td>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </td>
                        </tr>
                    </tbody>
                </table>

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