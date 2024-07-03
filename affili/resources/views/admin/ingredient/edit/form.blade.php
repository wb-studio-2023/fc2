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
    <section id="edit">
        <h2>{{ $pageName }}</h2>
        <div class="edit">
            <form method="POST" action="{{ route('admin.ingredient.edit.confirm') }}">
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
                                <input type="text" name="title" value="@if (!empty(old('title'))){{ old('title') }}@else{{ $ingredientData->title }}@endif">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                効能・栄養
                            </th>
                            <td>
                                <textarea name="effect">@if (!empty(old('effect'))){{ old('effect') }}@else{{ $ingredientData->effect }}@endif</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table_separate"></div>

                <div class="button_area">
                    <button type="submit">確認画面へ</button>
                </div>
                <input type="hidden" name="id" value="{{ $ingredientData->id }}">
            </form>

        </div>
    </section>

    <div class="separate"></div>
</div>
@endsection