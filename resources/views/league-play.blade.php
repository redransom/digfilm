@extends('layouts.site')

@section('content')
<h2><span>Welcome to the "{{$currentLeague->name}}" League</span></h2>
<div class="content-padding">

    @if($currentLeague->description != '')
    <h4><em>{{$currentLeague->description}}</em></h4>
    @endif
    
    <h2>Film Auction List</h2>
    @if(is_null($currentLeague->auction_start_date))
    <p>The auction will start soon!</p>

    @elseif(strtotime($currentLeague->auction_start_date) > time())
    <p>The auction will start on the <strong>{{date("jS F Y g:iA", strtotime($currentLeague->auction_start_date))}}</strong>.</p>
    @elseif($currentLeague->auctions()->count() > 0)
    <?php $players = $currentLeague->players->lists('name', 'id'); ?>

    @if($currentLeague->rule->blind_bid != 'Y')

    @include('partials.user-auctions', ['currentLeague'=>$currentLeague, 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'blind'=>false, 'previousBids'=>$previous_bids])

    @include('partials.user-expired-auctions', ['tableTitle'=>'Films Purchased', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$wonAuctions])

    @else

    @include('partials.site-blind-auction', ['currentLeague'=>$currentLeague, 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'previousBids'=>$previous_bids])

    @include('partials.user-expired-auctions', ['tableTitle'=>'Films Bid For', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$wonAuctions])

    @endif

    @include('partials.user-expired-auctions', ['tableTitle'=>'Expired Movies', 'players'=>$players, 'leagueUser'=>$currentLeagueUser, 'auctions'=>$expiredAuctions])

    @else
    <p>The auction is almost ready!</p>
    @endif

    @if(is_null($currentLeague->auction_start_date) || (strtotime($currentLeague->auction_start_date) > time())) 
    <h2>Players</h2>
    <p>Who you are competing against.</p>
    @if($currentLeague->players->count())
    <ul>
        @foreach($currentLeague->players as $player)
        <li>{{$player->name}}</li>
        @endforeach
    </ul>
    @endif
    
    <br/>
    <h2>Movies is great</h2>
    <p>This is a list of all movies that are to be played for in this league.</p>

        @if($currentLeague->movies->count() > 0)

            <?php $movieCnt = 0; ?>
            <ul id="movie-badge" class="clearfix">
            @foreach($movies as $movie)
                @if(($movieCnt % 4) == 0 && $movieCnt != 0)
                <li class="last">
                @else
                <li>
                @endif
                
                @if($movie->firstImage())
                    <img src="{{$movie->firstImage()->path()}}" alt="{{$movie->firstImage()->description}}" width="100px"/>
                @endif
                <a href="{{URL('movie-knowledge', [$movie->slug()])}}">{{$movie->name}}</a>
                @if($movie->opening_bid != 0)
                <br/>Opening Bid: <strong>${{$movie->opening_bid}}</strong>
                @endif
                </li>
                <?php $movieCnt++;?>
            @endforeach
            </ul>
        @endif
    
    <br/>
    @elseif(!is_null($currentLeague->round_amount))

    @include('partials.site-movies', ['movies'=>$currentLeague->movies()->where('chosen', '0')->get(), 'description'=>'This is a list of all movies that are to be played for in this league', 'sectionTitle'=>'Remaining Movies'])
    
    @endif
    @include('partials.user-league-rules', ['rule'=>$currentLeague->rule, 'leagueUser'=>$currentLeagueUser]) 
</div>

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