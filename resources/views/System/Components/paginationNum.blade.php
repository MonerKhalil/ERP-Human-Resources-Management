@if($PaginationData instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $PaginationData->total()>$PaginationData->perPage())
    <div class="Pagination--Numbers">
        <ul class="Pagination__List">
            @php
                $ArrayPaging = [] ;
                foreach ($PaginationData->withQueryString()->links()->elements as $Value_1)
                    if(is_array($Value_1))
                        foreach ($Value_1 as $index_2=>$Value_2)
                            $ArrayPaging[$index_2] = $Value_2 ;
                $PartDir = ($PartsViewNum - 1) / 2 ;
            @endphp
            @if($PaginationData->currentPage() > 1)
                <li class="Pagination__Previous">
                    <a href="{{$ArrayPaging[$PaginationData->currentPage()-1]}}">Prev</a>
                </li>
            @endif
            @if($PaginationData->currentPage() - $PartDir > 1)
                <li class="Pagination__Number">
                    <a href="{{$ArrayPaging[1]}}">1</a>
                </li>
                <li class="Pagination__Points">....</li>
            @endif
            @for($i = $PartDir ; $i >= 1 ; $i--)
                @if($PaginationData->currentPage() - $i >= 1)
                    <li class="Pagination__Number">
                        <a href="{{$ArrayPaging[$PaginationData->currentPage() - $i]}}">{{$PaginationData->currentPage() - $i}}</a>
                    </li>
                @endif
            @endfor
            <li class="Pagination__Number">
                <a href="{{$ArrayPaging[$PaginationData->currentPage()]}}" class="Current">{{$PaginationData->currentPage()}}</a>
            </li>
            @for($i = 1 ; $i <= $PartDir ; $i++)
                @if($PaginationData->currentPage() + $i <= $PaginationData->lastPage())
                    <li class="Pagination__Number">
                        <a href="{{$ArrayPaging[$PaginationData->currentPage() + $i]}}">{{$PaginationData->currentPage() + $i}}</a>
                    </li>
                @endif
            @endfor
            @if($PaginationData->currentPage() + $PartDir < $PaginationData->lastPage())
                <li class="Pagination__Points">....</li>
                <li class="Pagination__Number">
                    <a href="{{$ArrayPaging[$PaginationData->lastPage()]}}">{{$PaginationData->lastPage()}}</a>
                </li>
            @endif
            @if($PaginationData->currentPage() < $PaginationData->lastPage())
                <li class="Pagination__Next">
                    <a href="{{$ArrayPaging[$PaginationData->currentPage() + 1]}}">Next</a>
                </li>
            @endif
        </ul>
    </div>
@endif

{{--
    $PaginationData : For All Page Data ,
    $PartsViewNum : For Detirmine Count of item we need view it between prev & next
--}}









































{{--@if($PaginationData instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $PaginationData->total()>$PaginationData->perPage())--}}
{{--    <div class="Pagination--Numbers">--}}
{{--        <ul class="Pagination__List">--}}
{{--            @php--}}
{{--                $PartDir = ($PartsViewNum - 1) / 2 ;--}}
{{--            @endphp--}}
{{--            @if($PaginationData->currentPage() > 1)--}}
{{--                <li class="Pagination__Previous">--}}
{{--                    <a href="{{$PaginationData->withQueryString()->links()->elements[0][$PaginationData->currentPage() - 1]}}">Prev</a>--}}
{{--                </li>--}}
{{--            @endif--}}
{{--            @if($PaginationData->currentPage() - $PartDir > 1)--}}
{{--                <li class="Pagination__Number">--}}
{{--                    <a href="{{$PaginationData->withQueryString()->links()->elements[0][1]}}">1</a>--}}
{{--                </li>--}}
{{--                <li class="Pagination__Points">....</li>--}}
{{--            @endif--}}
{{--            @for($i = $PartDir ; $i >= 1 ; $i--)--}}
{{--                @if($PaginationData->currentPage() - $i >= 1)--}}
{{--                    <li class="Pagination__Number">--}}
{{--                        <a href="{{$PaginationData->withQueryString()->links()->elements[0][$PaginationData->currentPage() - $i]}}">{{$PaginationData->currentPage() - $i}}</a>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--            @endfor--}}
{{--            <li class="Pagination__Number">--}}
{{--                <a href="{{$PaginationData->withQueryString()->links()->elements[0][$PaginationData->currentPage()]}}" class="Current">{{$PaginationData->currentPage()}}</a>--}}
{{--            </li>--}}
{{--            @for($i = 1 ; $i <= $PartDir ; $i++)--}}
{{--                @if($PaginationData->currentPage() + $i <= $PaginationData->lastPage())--}}
{{--                    <li class="Pagination__Number">--}}
{{--                        <a href="{{$PaginationData->withQueryString()->links()->elements[0][$PaginationData->currentPage() + 1]}}">{{$PaginationData->currentPage() + $i}}</a>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--            @endfor--}}
{{--            @if($PaginationData->currentPage() + $PartDir < $PaginationData->lastPage())--}}
{{--                <li class="Pagination__Points">....</li>--}}
{{--                <li class="Pagination__Number">--}}
{{--                    <a href="{{$PaginationData->withQueryString()->links()->elements[0][$PaginationData->lastPage()]}}">{{$PaginationData->lastPage()}}</a>--}}
{{--                </li>--}}
{{--            @endif--}}
{{--            @if($PaginationData->currentPage() < $PaginationData->lastPage())--}}
{{--                <li class="Pagination__Next">--}}
{{--                    <a href="{{$PaginationData->withQueryString()->links()->elements[0][$PaginationData->lastPage() + 1]}}">Next</a>--}}
{{--                </li>--}}
{{--            @endif--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}

{{----}}
{{--    $PaginationData : For All Page Data ,--}}
{{--    $PartsViewNum : For Detirmine Count of item we need view it between prev & next--}}
{{----}}
