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
    <section id="top_slider">
        @include('front.pc.partical.contents.slider.slide')
    </section>

    <div id="contents">
        <section id="top_list_select">
            @include('front.pc.partical.section_title', ['sectionTitle' => '最新動画'])
            @include('front.pc.partical.contents.list.article_grid', ['articleList' => $latestArticleList])
            @include('front.pc.partical.contents.button.more', ['destinationLink' => 'front.article.search'])
        </section>

        <section id="top_recommend">
            @include('front.pc.partical.section_title', ['sectionTitle' => 'おすすめ動画'])
            @include('front.pc.partical.contents.list.article_grid', ['articleList' => $recommendArticleList])
        </section>

        <section id="top_tag">
            @include('front.pc.partical.section_title', ['sectionTitle' => 'おすすめタグ'])
            @include('front.pc.partical.contents.list.simple', ['page' => 'tag', 'dataList' => $tagList])
            @include('front.pc.partical.contents.button.more', ['destinationLink' => 'front.tag.list'])
        </section>
    </div>    
@endsection