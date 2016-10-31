@extends('layouts.email')

@section('content')
<!-- start textbox-with-title -->
<table width="100%" bgcolor="#e8eaed" cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table bgcolor="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="20"></td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; font-weight:bold; color: #333333; text-align:left;line-height: 24px;">
                                                Hi {{$inviteName}}, 
                                             </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          <tr>
                                             <td height="5"></td>
                                          </tr>
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #333333; text-align:left;line-height: 24px;">
                                             <p><strong>{{$ownerName}}</strong> has invited you to join <strong>{{$league->name}}</strong> which is due to start <em>{{date("j M Y g:iA", strtotime($league->auction_start_date))}}</em>.</p>  
                                             <p>Your account will be credited with 100 virtual pounds as soon as you choose to accept.</p> 
                                               <br/>
                                               If you want to join in - please follow this link: <em>{{URL::to('accept-invite/'.$invite_id)}}</em> or if you want to decline use
                                               this link <em>{{URL::to('decline-invite/'.$invite_id)}}</em>.
                                             </td>
                                          </tr>
                                          <!-- End of content -->
                                          <!-- Spacing -->
                                          <tr>
                                             <td width="100%" height="5"></td>
                                          </tr>
                                          <!-- Spacing -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #333333; text-align:left;line-height: 24px;">
                                               The rules of the league are:
                                               <dl>
                                                <dt>Players</dt>
                                                <dd>Min: {{$league->rule->min_players}} Max: {{$league->rule->max_players}}</dd>
                                                <dt>Movies</dt>
                                                <dd>Min: {{$league->rule->min_movies}} Max: {{$league->rule->max_movies}}</dd>
                                                <dt>Durations</dt>
                                                <dd>Auction: {{$league->rule->auction_duration}} hours <br/>Round: {{$league->rule->round_duration}} hours <br/>Movies: {{$league->rule->ind_film_countdown}} mins</dd>
                                                <dt>Bids</dt>
                                                <dd>Min: {{$league->rule->min_bid}} Max: {{$league->rule->max_bid}}</dd>
                                                <dt>Selection</dt>
                                                <dd>Random: {{($league->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($league->rule->auto_select == 'Y') ? "Yes" : "No"}} 
                                                    @if(!is_null($league->rule->auction_movie_release))
                                                    <br/>Grouped: {{$league->rule->auction_movie_release}}
                                                    @endif</dd>
                                                <dt>Blind</strong></dt>
                                                <dd>{{$league->rule->blind_bid == "Y" ? "Yes" : "No"}}</dd>
                                                <dt>Misc</strong></dt>
                                                <dd>Timeout: {{$league->rule->auction_timeout}} mins <br/>Denomination: {{$league->rule->denomination}} <br/>Movie Takings: {{$league->rule->movie_takings_duration}} weeks</dd>
                                              </dl>
                                             </td>
                                          </tr>

                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of textbox-with-title -->
@endsection