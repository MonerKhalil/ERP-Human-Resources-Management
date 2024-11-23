<div class="Breadcrumb">
    <div class="Container--MainContent">
        <div class="Breadcrumb__Header">
            <h2 class="Breadcrumb__Title">{{ $mainTitle }}</h2>
            @if(isset($paths))
                <ul class="Breadcrumb__Path">
                    @foreach($paths as $path)
                        @if(!$loop->last)
                            <li class="Link"><a href="{{ $path[1] }}">{{ $path[0] }}</a></li>
                            <li class="Separate">/</li>
                        @else
                            <li class="Current">{{ $path[0] }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="Breadcrumb__Summery">
            <p class="Summery">{{ $summery }}</p>
        </div>
    </div>
</div>
