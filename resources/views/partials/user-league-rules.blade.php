    <h2>Rules</h2>
        <table class="feature-table dark-gray">
            <tr>
                <td>Players</td>
                <td>Min: {{$rule->min_players}} Max: {{$rule->max_players}}</td>
            </tr>
            <tr>
                <td>Movies</td>
                <td>Min: {{$rule->min_movies}} Max: {{$rule->max_movies}}</td>
            </tr>
            <tr>
                <td>Durations</td>
                <td>Auction: {{$rule->auction_duration}} hours 
                @if($rule->round_duration != 0)
                <br/>Round: {{$rule->round_duration}} hours 
                @endif
                <br/>Movies countdown: {{$rule->ind_film_countdown}} mins</td>
            </tr>
            <tr>
                <td>Bids</td>
                <td>Min: {{$rule->min_bid}} Max: {{$rule->max_bid}}</td>
            </tr>
            <tr>
                <td>Selection</td>
                <td>Random: {{($rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($rule->auto_select == 'Y') ? "Yes" : "No"}} 
                @if(!is_null($rule->auction_movie_release))
                <br/>Grouped: {{$rule->auction_movie_release}}
                @endif</td>
            </tr>
            <tr>
                <td>Blind</td>
                <td>{{$rule->blind_bid == "Y" ? "Yes" : "No"}}</td>
            </tr>
            <tr>
                <td>Misc</td>
                <td>Timeout: {{$rule->auction_timeout}} mins <br/>Denomination: {{$rule->denomination}} <br/>Movie Takings: {{$rule->movie_takings_duration}} weeks</td>
            </tr>
        </table>