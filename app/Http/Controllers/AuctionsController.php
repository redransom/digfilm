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
use App\Models\LeagueRule;
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

        if ($status == '')
            $leagues = League::whereIn('auction_stage', ['0', '1', '2', '3'])->get();
        elseif($status == '1')
            $leagues = League::whereIn('auction_stage', ['0', '1'])->get();
        elseif($status == '2')
            $leagues = League::where('auction_stage', '2')->get();
        elseif($status == '3')
            $leagues = League::where('auction_stage', '>', '3')->get();

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
            $auction->initial_bid = $input['bid_amount'];
        }

        //add the new bid to the auction
        Log::info('Bid on auction:'.$auction->id.' by user:'.$authUser->id.' amount:'.$input['bid_amount']);
        $auction->users_id = $authUser->id;
        $auction->bid_amount = $input['bid_amount'];

        //add minutes to bid
        if ($rule->ind_film_countdown != 0) {
            //$auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+1 hour', strtotime('+'.intval($rule->ind_film_countdown).' minutes', time())));
            $auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+'.intval($rule->ind_film_countdown).' minutes', time()));
        } else {
            //default it to 10 minutes
            //$auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+1 hour', strtotime('+10 minutes', time())));
            $auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+10 minutes', time()));
        }

        if($auction->timeout != 0) {
            //$auction->timeout_date = date("Y-m-d H:i:s", strtotime('+1 hour', strtotime('+'.intval($auction->timeout).' minutes', time())));
            $auction->timeout_date = date("Y-m-d H:i:s", strtotime('+'.intval($auction->timeout).' minutes', time()));
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
        $leagueUser = LeagueUser::where('league_id', $auction->leagues_id)->where('user_id', $authUser->id)->first();
        $rule = $league->rule;

        return View("auctions.placebid")
            ->with('authUser', $authUser)
            ->with('leagueUser', $leagueUser)
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
        $currentTime = date("Y-m-d H:i:s"); //, strtotime("+1 hour", time()));
        Log::info("Current Time to clear out: ".$currentTime);
        $auctionsToClear = Auction::where('ready_for_auction', '1')->where('auction_end_time', '<', $currentTime)->get();

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
        $currentTime = date("Y-m-d H:i:s"); //, strtotime("+1 hour", time()));
        Log::info("Current Time to clear time out: ".$currentTime);
        $auctionsToClear = Auction::where('ready_for_auction', '1')->where('timeout_date', '<', $currentTime)->get();

        //Auction::where('ready_for_auction', '1')->where('timeout_date', '<', $currentTime)
        //    ->update(['ready_for_auction'=>2]);
        if ($auctionsToClear->count() > 0) {
            foreach ($auctionsToClear as $auction) {
                Log::info("Auction End Time Out Cleared: ".$auction->id);
                $auction->ready_for_auction = 2; //finished
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

    /**
     * Set auction codes to 3 when the auction is closed and the auction has not been bidded on
     * Set auctuon code to 4 when the auction is closed and the auction has been bidded on 
     *
     * @param  int  $id
     * @return Response
     */
    public function prepareClearedAuctions() 
    {    
        Auction::where('ready_for_auction', '2')->where('bid_count', '0')->update(['ready_for_auction'=>3]);
        Auction::where('ready_for_auction', '2')->where('bid_count', '>', '0')->update(['ready_for_auction'=>4]);
    }


    /**
     * Set leagues to final stage when all auctions are complete
     *
     * @param  int  $id
     * @return Response
     */
    public function completeLeagues() 
    {    
    
        //look for leagues where the auction_stage = 2
        $leagues = League::where('auction_stage', 2)->get();

        //loop through leagues
        foreach($leagues as $league) {
            //we will need to check for round here to make sure there aren't more rounds to add
            $total_auction_count = $league->auctions()->count();
            $movie_count = $league->movies()->count();

            if ($total_auction_count == $movie_count) {
                $auction_count = $league->auctions()->where('ready_for_auction', '<', '2')->count();

                if ($auction_count == 0) {
                    //stage = 3 / auctions are over
                    $league->auction_stage = 3;
                    $league->save();
                }
            }
        }

    }
}
