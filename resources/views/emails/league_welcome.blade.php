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
                                                {{$subject}}
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
                                                Hi <strong>{{$playerName}}</strong>,<br/>
                                                You have joined the league <strong>{{$leagueName}}</strong>
                                                <br/>
                                                <p>Below are all the films available to purchase in your auction, these are selected from all films released in the UK from 7 days to 3 months after your auction begins. 
                                                Depending on the type of league, these will be released all at once or periodically over several days. </p>
                                                <p>We recommend you check out the trailers and various articles of films that catch your eye before playing so you can go into the auction with a winning strategy. </p>
                                                @if(isset($leagueMovies))
                                                <h3>Available Movies</h3>
                                                <ol>
                                                @foreach($leagueMovies as $movie)
                                                   <li>
                                                   @if($movie->firstImage())
                                                   <img src="{{asset($movie->firstImage()->path())}}" alt="{{$movie->name}} image" width="100px"/>
                                                   @endif
                                                   <a href="{{URL('movie-knowledge', ['id'=>$movie->link()])}}">{{$movie->name}}</a>                              
                                                   </li>
                                                @endforeach
                                                </ol>
                                                <br/>
                                                <p>Depending on the league rules, they will be released all at the same time or in groups.</p>
                                                @else
                                                <p>The movies will be added soon and you will receive an email confirming this.</p>
                                                @endif
                                                <p>We wish you the best of luck!</p>
                                                <p><strong>The Next Big Film</strong></p>
                                             </td>
                                          </tr>
                                          <!-- End of content -->
                                          <!-- Spacing -->
                                          <tr>
                                             <td width="100%" height="5"></td>
                                          </tr>
                                          <!-- Spacing -->
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