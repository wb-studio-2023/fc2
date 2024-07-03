<div class="search_form">
    {{ Form::open( ['route' => $searchRoute, 'method' => 'post',]) }}
    {{ Form::label('keyword', '検索ワード：') }}
    {{ Form::text('keyword', $arrayRequest['keyword']) }}
    {{ Form::submit('検索') }}
    {{ Form::close() }}
</div>