@extends('layouts.blank')

@section('content')
<div class="content">

    <h3>Place Bid</h3>
    <p>Bid on <strong>{{$auction->movie->name}}</strong>.</p>
    {!! Form::open(array('route' => array('auctions.update', $auction->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="control-group">
            <label class="control-label" for="AuctionAmount">Amount</label>
            <div class="controls">
                {!! Form::text('bid_amount', (($auction->users_id == 0) ? 0 : $auction->bid_amount), ['class'=>'span8', 'min'=>$rule->min_bid]) !!}
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary pull-right">Bid</button>
            </div>
        </div>
    </form>
    
</div>
@endsection