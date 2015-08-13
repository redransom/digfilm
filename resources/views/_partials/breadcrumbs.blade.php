@if ($breadcrumbs)
    <ol class="breadcrumb bc-1" >
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->first)
                <li class="active"><a href="/dashboard"><i class="fa-home"></i>Home</a></li>
            @elseif (!$breadcrumb->last)
                <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
            @else
                <li class="active">{{{ $breadcrumb->title }}}</li>
            @endif
        @endforeach
    </ol>
@endif