<?php function auctionTimer ($auctionid, $auctionTime, $name='bid_link') { ?>
    <div id="{{$name}}_<?php echo $auctionid; ?>"></div>
    <script type="text/javascript">
      $('#{{$name}}_<?php echo $auctionid; ?>').countdown('<?php echo $auctionTime; ?>', function(event) {
        <?php 
        $timeDiff = strtotime($auctionTime) - time();
        //if auction finish time - current time is over an hour then show the hour not just the minute
        if ($timeDiff > 86400) { ?>
        $(this).html(event.strftime('%-D day(s) %-H:%M:%S'));
        <?php } elseif ($timeDiff > 3600) { ?>
        $(this).html(event.strftime('%-H:%M:%S'));
        <?php } else { ?>
        $(this).html(event.strftime('%M:%S'));
        <?php } ?>
        if(event.elapsed) {
            $('#{{$name}}_{{$auctionid}}').val = "ENDED";
        }
      });
    </script>
<?php } ?>