@extends('layouts.users')

@section('content')
<section class="entry sbr clearfix">
    <div class="title-caption-large">
        <h3>{{$league->name}} League</h3>
    </div>

    <h2>Auction</h2>
    @if(is_null($league->auction_start_date))
    <p>The auction will start soon!</p>
    @elseif(strtotime($league->auction_start_date) > time())
    <p>The auction will start on the <strong>{{date("d M y h:iA", strtotime($league->auction_start_date))}}</strong>.</p>
    @else
    <?php $players = $league->players->lists('name', 'id'); ?>
    <p>See a list of movies you can bid on:</p>

    <table class="feature-table dark-gray">
        <thead>
            <tr><th>Movie</th><th>Release Date</th><th>Current Price /<br/>$ USD</th><th>Place Bid</th><th>Owner</th><th>Time</th><th>Active</th></tr>
        </thead>
        <tbody>
        <script>
           $(function() {
        var dialog, form,
     
          // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
          emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
          name = $( "#name" ),
          email = $( "#email" ),
          password = $( "#password" ),
          allFields = $( [] ).add( name ).add( email ).add( password ),
          tips = $( ".validateTips" );

          function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "username", 3, 16 );
      valid = valid && checkLength( email, "email", 6, 80 );
      valid = valid && checkLength( password, "password", 5, 16 );
 
      valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
      valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
      valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
      if ( valid ) {
        $( "#users tbody" ).append( "<tr>" +
          "<td>" + name.val() + "</td>" +
          "<td>" + email.val() + "</td>" +
          "<td>" + password.val() + "</td>" +
        "</tr>" );
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Create an account": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( "#create-user" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
  });
    </script>
        @foreach($league->auctions as $auction)
            <tr><td><a href="{{URL('movie-knowledge', [$auction->id])}}">{{$auction->name}}</a></td>
            <td>{{date("j-M-y", strtotime($auction->release_at))}}</td><td>{{$auction->pivot->bid_amount}}</td>
            @if($auction->pivot->users_id == $authUser->id)
            <td>PLACED</td>
            @else
            <td><a href="{{URL('place-bid', [$auction->pivot->id])}}" class="popup">PLACE BID</a></td>
            @endif
            @if($auction->pivot->users_id != 0)
            <td>{{$players[$auction->pivot->users_id]}}</td>
            @else
            <td>&nbsp;</td>
            @endif
            <td><?php auctionTimer($auction->pivot->id, $league->auction_close_date,  $auction->pivot->auction_end_time); ?></td>
            @if($auction->pivot->ready_for_auction == 1)
            <td>Yes</td>
            @else
            <td>No</td>
            @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    @if(is_null($league->auction_start_date) || (strtotime($league->auction_start_date) > time())) 
    <h2>Players</h2>
    <p>Who you are competing against.</p>
    @if($league->players->count())
    <ul>
        @foreach($league->players as $player)
        <li>{{$player->name}}</li>
        @endforeach
    </ul>
    @endif

    <br/>
    <h2>Movies</h2>
    <p>This is a list of all movies that are to be played for in this league.</p>
    @if($league->movies->count() > 0)
    <ul>
    @foreach($league->movies as $movie)
        <li>{{$movie->name}}</li>
    @endforeach
    </ul>
    @endif
    @endif
</section>

<?php function auctionTimer ($auctionid, $auctionDate, $auctionTime) { ?>
    <div id="timer<?php echo $auctionid; ?>"></div>
    <script type="text/javascript">
      $('#timer<?php echo $auctionid; ?>').countdown('<?php echo date("Y-m-d", strtotime($auctionDate))." ".$auctionTime; ?>', function(event) {
        $(this).html(event.strftime('%-H:%M:%S'));
      });
    </script>
<?php } ?>

@endsection
