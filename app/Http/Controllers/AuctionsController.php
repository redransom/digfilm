<?php namespace App\Http\Controllers;

use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Contributor;
use App\Models\ContributorType;
use App\Models\Role;
use App\Models\Auction;
use App\Models\League;
use App\Models\LeagueUser;
use Session;
use Input;
use Redirect;
use Flash;
use Illuminate\Http\Request;

class AuctionsController extends Controller {

    /**
     * Display a listing of the rule sets.
     *
     * @return Response
     */
    public function index($status = '')
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $leagues = League::where('auction_stage', '2')->paginate(10);

        return View("auctions.all")
            ->with('leagues', $leagues)
            ->with('authUser', $authUser)
            ->with('page_name', 'auctions')
            ->with('instructions', 'All Auctions.')
            ->with('title', 'Auctions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $types = ContributorType::lists('name', 'id');

        return View("contributors.add")
            ->with('authUser', $authUser)
            //->with('contributor_types', $types)
            ->with('page_name', 'contributor-add')
            ->with('instructions', 'Add New Contributor to Database')
            ->with('title', 'Add Contributor');
    }

    /**
     * Store new bid
     *
     * @return Response
     */
    public function store()
    {
        //      
        $input = Input::all();

        if ($request->file('thumbnail') != "") {
            $imageName = $contributor->id.str_replace(' ', '_', strtolower($input['first_name'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move(base_path() . '/public/images/contributors/', $imageName);

            $contributor->thumbnail = "/images/contributors/".$imageName;
            $contributor->save();
        }


        return Redirect::route('contributors.index')->with('message', 'Contributor created.');

    }

    /**
     * Display the specified resource.
     *  
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $contributor = Contributor::find($id);
        $title = "Contributor ".$contributor->name;

        return View("contributors.show")
            ->with('authUser', $authUser)
            ->with('contributor', $contributor)
            ->with('object', $contributor)
            ->with('page_name', 'contributor-show')
            ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $contributor = Contributor::find($id);
        $title = "Edit Contributor";

        return View("contributors.edit")
            ->with('authUser', $authUser)
            ->with('contributor', $contributor)
            ->with('object', $contributor)
            ->with('page_name', 'contributor-edit')
            ->with('title', $title);
    }

    /**
     * Update the auction
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $auction = Auction::find($id);
        $rule = $auction->league->rule;
        $input = $request->all();

        if($auction->bid_count != 0) {
            //some one else has bid on it previously
            $bid_refund = $auction->bid_amount;
            $prev_bid_user = $auction->users_id;
        } else {
            //record opening bid for analysis purposes
            $auction->opening_bid = $input['bid_amount'];
        }

        //add the new bid to the auction
        Log::info('Bid on auction:'.$auction->id.' by user:'.$authUser->id.' amount:'.$input['bid_amount']);
        $auction->users_id = $authUser->id;
        $auction->bid_amount = $input['bid_amount'];

        //add minutes to bid
        if ($rule->ind_film_countdown != 0) {
            $auction->auction_end_time = date("H:i:s", strtotime('+'.$rule->ind_film_countdown.' minutes', time()));
        }

        $auction->bid_count++;
        $auction->save();

        //remove amount from users balance / need to do a check to see if it overrides a previous users amount and gives it too them back
        Log::info('Reduce balance by user:'.$authUser->id.' amount:'.$input['bid_amount']);
        $leagueUser = LeagueUser::where('league_id', $auction->leagues_id)->where('user_id', $authUser->id)->first();
        $leagueUser->balance -= $input['bid_amount'];
        $leagueUser->save();
        unset($leagueUser);

        if (isset($bid_refund)) {
            Log::info('Refund user:'.$prev_bid_user.' amount:'.$bid_refund);
            $leagueUser = LeagueUser::where('league_id', $auction->leagues_id)->where('user_id', $prev_bid_user)->first();
            $leagueUser->balance += $bid_refund;
            $leagueUser->save();

        }

        return Redirect::route('league-show', [$auction->leagues_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Close the auction
     *
     * @param  int  $id
     * @return Response
     */
    public function close($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $auction = Auction::find($id);
            $message = "";
            if (!empty($auction)) {
                $movie = $auction->movie;
                $league = $auction->league;

                $message = "Auction " .$movie->name. " has been closed in league ".$league->name.".";
                Flash::message($message);
                $auction->ready_for_auction = 2;
                $auction->save();
            }
            return Redirect::route('auctions.index');
        }
        Flash::message('You don\'t have the permissions to complete this task.');
        return Redirect::route('auctions.index');
    }

    /**
     * Bid on auction
     *
     * @param  int  $id
     * @return Response
     */
    public function placeBid($id)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $auction = Auction::find($id);
        $league = League::find($auction->leagues_id);
        $rule = $league->rule;

        return View("auctions.placebid")
            ->with('authUser', $authUser)
            ->with('auction', $auction)
            ->with('rule', $rule);
    }

    /**
     * Clear out auction movies who are live and whose end time is passed.
     *
     * @param  int  $id
     * @return Response
     */
    public function clearEndTimeAuctions() 
    {
        $auctionsToClear = Auction::where('ready_for_auction', '1')->where('auction_end_time', '<', time())->get();

        if ($auctionsToClear->count() > 0) {
            foreach ($auctionsToClear as $auction) {
                Log::info("Auction End Time Cleared: ".$auction->id);
                $auction->ready_for_auction = 2; //finished
                $auction->save();
            }    
        }

    }

    /**
     * Clear out auction movies who are live and whose last bid time was over the league rule
     *
     * @param  int  $id
     * @return Response
     */
    public function clearTimeoutAuctions() 
    {    
        $rules = LeagueRule::where('auction_timeout', '>', '0')->get();
        $affected_league = array();
        foreach($rules as $rule) {
            $affected_league[] = $rule->leagues_id;
        }
        
        //get all auctions that are live and in the affected leagues
        $auctionsTimedOut = Auction::whereIn('leagues_id', $affected_league)->where('ready_for_auction', '1')->get();

        foreach ($auctionsTimedOut as $auction) {
            //get the time the auction was last updated and add the auction time out to it
            //if this new time is less than now than it needs to be closed
            $rule = $this->getLeagueRule($rules, $auction->leagues_id);
            $test_time = date("H:i:s", strtotime($auction->updated_at)."+".$rule->auction_timeout." minutes");  
            if ($test_time < time()) {
                $auction->ready_for_auction = 2;
                Log::info("Auction Time Out Cleared: ".$auction->id);
                $auction->save();
            }
        }
    }

    private function getLeagueRule($rules, $league_id) {
        foreach ($rules as $rule) {
            if ($rule->league_id == $league_id)
                return $rule;
        }
    }

    //set auction codes to 3 when the auction is closed and the auction has not been bidded on
    //set auctuon code to 4 when the auction is closed and the auctuion has been bidded on

    

}
