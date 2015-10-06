<?php namespace App\Http\Controllers;

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
        $input = $request->all();

        $auction->users_id = $authUser->id;
        $auction->bid_amount = $input['bid_amount'];
        $auction->bid_count++;
        $auction->save();

        return Redirect::route('league', [$auction->leagues_id]);
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

}
