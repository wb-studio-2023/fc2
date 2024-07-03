@extends('front.pc.layout')

@section('title')
@endsection

@section('css')
@endsection

@section('js')
@endsection

@section('content')
<div id="contents">
    <section>
        @include('front.pc.partical.contents.article.detail')
    </section>
    <section>
        @include('front.pc.partical.section_title', ['sectionTitle' => '関連動画'])
        @include('front.pc.partical.contents.list.article_grid', ['articleList' => $relativeArticleList])
    </section>
</div>
@endsection

