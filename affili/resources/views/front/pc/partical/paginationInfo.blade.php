<div id="pagination_info">
    @if ($paginator->hasPages())
        <div class="pagination_info">
            <div class="total">
                {{ $paginator->total() }}件中
            </div>
            <div class="current">
                {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }}件
                ～
                @if ($paginator->lastPage() > $paginator->currentPage())
                    {{ ($paginator->currentPage()) * $paginator->perPage() }}件
                @else
                    {{ $paginator->total() }}件
                @endif
                を表示          
            </div>
        </div>
    @endif
</div>