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
        @include('front.pc.partical.contents.list.article_grid')
        {{ $articleList->links('front.pc.partical.pagination') }}
        {{ $articleList->links('front.pc.partical.paginationInfo') }}
    </section>
</div>
@endsection