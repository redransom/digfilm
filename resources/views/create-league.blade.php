@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>Create Your League</h3>
    </div>

    @if(isset($authUser))
    <p></p>
    @else
    <p>You can create a league here for your friends to play in.</p>
    @endif

</section>

@endsection