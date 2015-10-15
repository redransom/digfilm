@extends('layouts.blank')

@section('content')
<div class="content">

    <h3>Place Bid</h3>
    <?php
        $min_bid = $rule->min_bid;
        $bid_amount = $auction->bid_amount;

        if ($bid_amount != 0 && $bid_amount > $rule->min_bid) {
            $min_bid = $bid_amount;
        }

        $max_bid = $rule->max_bid;
        //make sure user cant overspend on this league
        if ($max_bid > $leagueUser->balance)
            $max_bid = $leagueUser->balance;
    ?>
    <p>Bid on <strong>{{$auction->movie->name}}</strong>.</p>
    <p>You may bid between <strong>{{$min_bid}}USD</strong> and <strong>{{$max_bid}}USD</strong>.</p>
    {!! Form::open(array('route' => array('auctions.update', $auction->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="control-group">
            <label class="control-label" for="AuctionAmount">Amount</label>
            <div class="controls">
                {!! Form::number('bid_amount', $min_bid, ['class'=>'span8', 'min'=>$min_bid, 'max'=>$max_bid, 'type'=>'number', 'step'=>'0.5', 'required']) !!}
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