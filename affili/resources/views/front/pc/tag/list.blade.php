@extends('front.pc.layout')

@section('title')
@endsection

@section('css')
@endsection

@section('js')
@endsection

@section('component')
@endsection

@section('content')
<div id="contents">
    <section id="page_title">
        @include('front.pc.partical.page_title')
        @include('front.pc.partical.contents.form.search')
        @include('front.pc.partical.contents.list.simple',  ['page' => 'tag', 'dataList' => $tagList])
    </section>
</div>
@endsection