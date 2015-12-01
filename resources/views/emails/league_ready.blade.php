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
                                                League Auction is due to start!
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
                                                Hi <strong>{{$playerName}}</strong>!<br/>
                                                The league auction is about to start with the following movies available to bid on:<br/>
                                                <ol>
                                                @foreach($leagueMovies as $movie)
                                                   <li>
                                                   @if($movie->firstImage())
                                                   <img src="{{$movie->firstImage()->file_name}}" alt="{{$movie->name}} image" width="100px"/>
                                                   @endif
                                                   @if(!is_null($movie->slug))
                                                    <a href="{{URL('movie-knowledge', ['id'=>$movie->slug])}}">{{$movie->name}}</a>
                                                   @else
                                                   <a href="{{URL('movie-knowledge', ['id'=>$movie->id])}}">{{$movie->name}}</a>
                                                   @endif
                                                   </li>
                                                @endforeach
                                                </ol>
                                                <br/>
                                                Depending on the league rules, they will be released all at the same time or in groups.
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