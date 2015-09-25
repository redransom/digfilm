@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$league->name}} League</h3>
    </div>

    {{var_dump($league)}}
</section>
@endsection
