    <h2><span>Rules</span></h2>
    <div class="content-padding">
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
                @if($rule->blind_bid != 'Y')
                <br/>Movies countdown: {{$rule->ind_film_countdown}} mins
                <br/>Timeout: {{$rule->auction_timeout}} mins
                @endif
                </td>
            </tr>
            @if($rule->blind_bid != 'Y')
            <tr>
                <td>Bids</td>
                <td>Min: {{$rule->min_bid}} Max: {{$rule->max_bid}}</td>
            </tr>
            <tr>
                <td>Increment</td>
                <td>Min: {{number_format($rule->min_increment, 2)}} Max: {{number_format($rule->max_increment, 2)}}</td>
            </tr>
            @else
            <tr>
                <td>Blind</td>
                <td>Yes</td>
            </tr>
            @endif
            <tr>
                <td>Selection</td>
                <td>Random: {{($rule->randomizer == "Y") ? "Yes" : "No"}} <br/>Auto-Select: {{($rule->auto_select == 'Y') ? "Yes" : "No"}} 
                @if(!is_null($rule->auction_movie_release))
                <br/>Grouped: {{$rule->auction_movie_release}}
                @endif</td>
            </tr>
            <tr>
                <td>Misc</td>
                <td>Movie Takings: {{$rule->movie_takings_duration}} weeks</td>
            </tr>
        </table>
    </div>