<div class="list_select">
    <div class="detail_list">
        <div class="simple_list">
            @if ($dataList->isNotEmpty())
                @foreach ($dataList as $data)
                    <div class="list_item">
                        <a href="{{ route('front.' . $page . '.article.list', [$page . '_id' => $data->id]) }}">
                            {{ $data->name }}
                        </a>            
                    </div>
                @endforeach
            @endif
        </div>    
    </div>    
</div>
