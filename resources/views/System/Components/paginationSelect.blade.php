{{--@if($PaginationData instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $PaginationData->total()>$PaginationData->perPage())--}}
{{--    <div class="Pagination--Select">--}}
{{--        <div class="Pagination__List">--}}
{{--            <span class="Pagination__PageWord">@lang("page")</span>--}}
{{--            <form class="Form Form--Dark" method="get">--}}
{{--                <div class="Form__Group">--}}
{{--                    <div class="Form__Input">--}}
{{--                        <div class="Input__Area">--}}
{{--                            <input id="PageNumber" class="IgnoreField Input__Field" type="number"--}}
{{--                                   min="1" max="{{$PaginationData->lastPage()}}"--}}
{{--                                   name="page" value="{{$PaginationData->currentPage()}}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--            <span class="Pagination__PageOf">--}}
{{--                <span style="padding: 0 .5rem">@lang("ofPage")</span>--}}
{{--                <span>{{$PaginationData->lastPage()}}</span>--}}
{{--            </span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

{{----}}
{{--    $PaginationData : For All Page Data--}}
{{----}}
