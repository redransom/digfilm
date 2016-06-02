<div class="content">

    <h3>Place Bid</h3>
    <?php
        $min_bid = $rule->min_bid;
        $opening_bid = $auction->opening_bid;
        $min_increment = (!is_null($rule->min_increment) && $rule->min_increment != 0) ? $rule->min_increment : 0.5;
        $max_increment = (!is_null($rule->max_increment) && $rule->max_increment != 0) ? $rule->max_increment : 1;
        $bid_amount = $auction->pivot->bid_amount;
        $blind = ($rule->blind_bid == 'Y');

        //echo "Bid: OB: $opening_bid MB: $min_bid BA: $bid_amount MI: $min_increment MC: $max_increment";
        if ($blind) {
            //if blind bid then there is no starting point due to previous bids
            $min_bid = $rule->min_bid;
            
        } else {

            if ($bid_amount != 0 && $bid_amount > $rule->min_bid) {
                //need to include the denomination so that we aren't lower or the same as the previous bid
                $min_bid = $bid_amount + $min_increment;
            } elseif($bid_amount == 0 && $opening_bid != 0)
                $min_bid = $opening_bid;

        }

        $max_bid = !is_null($rule->max_bid) ? $rule->max_bid : 0;
        //make sure the max amount bidable is less than the max increment if it is less than the max bid
        if (($min_bid + $max_increment) < $max_bid)
            $max_bid = ($min_bid + $max_increment);

        //make sure user cant overspend on this league
        if (($max_bid > $leagueUser->balance) || (is_null($max_bid) || $max_bid == 0))
            $max_bid = $leagueUser->balance;
    ?>
    <p>Your available balance is: <strong>{{number_format($leagueUser->balance, 2)}}</strong>.</p>
    <p>Bid on <strong>{{$auction->name}}</strong>.</p>
    <p>You may bid between <strong>{{number_format($min_bid, 2)}}USD</strong> and <strong>{{number_format($max_bid, 2)}}USD</strong>.</p>
    {!! Form::open(array('route' => array('auctions.update', $auction->pivot->id), 'class'=>'form-horizontal row-fluid', 'method'=>'PUT')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="control-group">
          
            <div class="controls">
                  <label class="control-label" for="AuctionAmount">Amount</label>
                {!! Form::number('bid_amount', $min_bid, ['class'=>'span8', 'min'=>$min_bid, 'max'=>$max_bid, 'type'=>'number', 'step'=>$min_increment, 'required']) !!}
                 <button type="submit" class="btn btn-primary bid-btn">Bid</button>
            </div>
        </div>

        <!--<div class="control-group">
            <div class="controls public">
                <button type="submit" class="btn btn-primary bid-btn">Bid</button>
            </div>
        </div>-->
    </form>
    
</div>