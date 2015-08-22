@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        @if($join_success)
        <h3>League Joined!</h3>
        @else
        <h3>Request to join denied!</h3>
        @endif
    </div>
    
    
</section>
@endsection