@extends('front.sp.layout')

@section('title')
今日何食べる？
@endsection

@section('css')
@endsection

@section('js')
@endsection

@section('component')
@endsection

@section('content')
<section id="top_slider">
    @include('front.sp.partical.contents.slider.slide')
</section>

<section id="top_list_select">
    @include('front.sp.partical.contents.list.select')
</section>

<section id="top_recommend">
    @include('front.sp.partical.section_title', ['sectionTitle' => 'おすすめレシピ'])
    @include('front.sp.partical.contents.list.grid')
    @include('front.sp.partical.contents.button.more')
</section>

<section id="top_column">
    @include('front.sp.partical.section_title', ['sectionTitle' => 'コラム'])
    @include('front.sp.partical.contents.list.vertical')
    @include('front.sp.partical.contents.button.more')
</section>

<section id="top_site_introduction">
    @include('front.sp.partical.section_title', ['sectionTitle' => 'おすすめコンテンツ'])
    @include('front.sp.partical.contents.introduction.site')
</section>

<section id="top_writer_introduction">
    @include('front.sp.partical.section_title', ['sectionTitle' => '中の人'])
    @include('front.sp.partical.contents.introduction.writer')
</section>
@endsection