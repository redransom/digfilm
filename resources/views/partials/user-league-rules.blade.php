    <h2>Rules</h2>
        <table class="feature-table dark-gray">
            <tr>
                <td>Players</td>
                <td>Min: {{$currentLeague->rule->min_players}} Max: {{$currentLeague->rule->max_players}}</td>
            </tr>
            <tr>
                <td>Movies</td>
                <td>Min: {{$currentLeague->rule->min_movies}} Max: {{$currentLeague->rule->max_movies}}</td>
            </tr>
            <tr>
                <td>Durations</td>
                <td>Auction: {{$currentLeague->rule->auction_duration}} hours <br/>Round: {{$currentLeague->rule->round_duration}} hours <br/>Movies: {{$currentLeague->rule->ind_film_countdown}} mins</td>
            </tr>
            <tr>
                <td>Bids</td>
                <td>Min: {{$currentLeague->rule->min_bid}} Max: {{$currentLeague->rule->max_bid}}</td>
            </tr>
            <tr>
                <td>Selection</td>
                <td>Random: {{($currentLeague->rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($currentLeague->rule->auto_select == 'Y') ? "Yes" : "No"}} 
                @if(!is_null($currentLeague->rule->auction_movie_release))
                <br/>Grouped: {{$currentLeague->rule->auction_movie_release}}
                @endif</td>
            </tr>
            <tr>
                <td>Blind</td>
                <td>{{$currentLeague->rule->blind_bid == "Y" ? "Yes" : "No"}}</td>
            </tr>
            <tr>
                <td>Misc</td>
                <td>Timeout: {{$currentLeague->rule->auction_timeout}} mins <br/>Denomination: {{$currentLeague->rule->denomination}} <br/>Movie Takings: {{$currentLeague->rule->movie_takings_duration}} weeks</td>
            </tr>
        </table>