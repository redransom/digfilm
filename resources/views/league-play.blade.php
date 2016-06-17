@extends('layouts.site')

@section('content')
<h2><span>Welcome to the "{{$currentLeague->name}}" League</span></h2>
<div class="content-padding">
    @if($currentLeague->description != '')
    <p><em>{{$currentLeague->description}}</em></p>
    @endif
</div>

<?php $players = $currentLeague->players->lists('name', 'id'); ?>

    @if($currentLeague->rule->blind_bid != 'Y' && $currentLeague->auction_stage < 3)
    <!-- Standard auction details -->
    @include('partials.user-auctions', ['currentLeague'=>$currentLeague, 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'blind'=>false, 'previousBids'=>$previous_bids])

    @include('partials.user-expired-auctions', ['tableTitle'=>'Films Purchased', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$wonAuctions])
    <!-- End Standard auction details -->
    @elseif($currentLeague->rule->blind_bid == 'Y' && $currentLeague->auction_stage < 3)
    <!-- Blind Auction -->
    @include('partials.site-blind-auction', ['currentLeague'=>$currentLeague, 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'previousBids'=>$previous_bids])

    @include('partials.user-expired-auctions', ['tableTitle'=>'Films Bid For', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$wonAuctions])
    <!-- End Blind Auction -->

    @else
    
    @include('partials.user-expired-auctions', ['tableTitle'=>'Films Bid For', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$wonAuctions])
    @endif

    @include('partials.user-expired-auctions', ['tableTitle'=>'Expired Movies', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$expiredAuctions])

    @include('partials.user-league-rules', ['rule'=>$currentLeague->rule, 'leagueUser'=>$currentLeagueUser]) 
 
<?php function auctionTimer ($auctionid, $auctionTime, $name='bid_link') { ?>
    <div id="{{$name}}_<?php echo $auctionid; ?>"></div>
    <script type="text/javascript">
      $('#{{$name}}_<?php echo $auctionid; ?>').countdown('<?php echo $auctionTime; ?>', function(event) {
        <?php 
        //if auction finish time - current time is over an hour then show the hour not just the minute
        if (strtotime($auctionTime) - time() > 3600) { ?>
        $(this).html(event.strftime('%-H:%-M:%S'));
        <?php } else { ?>
        $(this).html(event.strftime('%-M:%S'));
        <?php } ?>
        if(event.elapsed) {
            $('#{{$name}}{{$auctionid}}').val = "ENDED";
        }
      });
    </script>
<?php } ?>

@endsection