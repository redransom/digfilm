@extends('layouts.users')

@section('content')
<h1>Rules of the game</h1>
<dl>
    <dt>Default balance.</dt> 
    <dd>Every user is granted 100 virtual USD for each League they join.  
    This balance, along with other users in the same league should be presented on the Auction Dashboard.</dd>
    <dt>Players per League.</dt>
    <dd>The amount of players permitted per League can be greater than or equal to 4 AND less than or equal to 10.  
    4 ≤ n ≤ 10</dd>
    <dt>Films per League.</dt>  
    <dd>Each League Movie Roster can be greater than or equal to 40 AND less than or equal to 100.  40 ≤ n ≤ 100</dd>
    <dt>Joined League per Year.</dt>  
    <dd>The MAXIMUM number of Leagues any player can join per year is 10.</dd>
    <dt>Auction Bid increment policy.</dt>
    <dd>For each auction, the lowest bid increment a user can make on a film is .50 cent.  
    The highest bid increment is 10.00 USD.</dd>
    <dt>Joint Ownership policy.</dt>
    <dd>No two users of the same League can own/purchase the same film during the League Auction.</dd>
    <dt>Releasing a User's bid.</dt>
    <dd>Once a user places a bid on a film during a Movie Auction, there balance will reflect this as a reduction.  
    Example: a user starts with a 100 USD, and places a 5.00 USD bid on a film, there balance now reads 95.00 USD.  
    The 5.00 USD can only be returned to the user's balance if another player outbids the individual by .50 cent or more.</dd>
    <dt>Locked user bid</dt> 
    <dd>A user bid is locked to the film and they are NOT allowed to outbid themselves.  
    Example: if a user has placed 5.00 USD bid on a film, they can NOT outbid themselves by placing a bid greater than 5.00 USD.</dd>
    <dt>Span of earliest to latest League Movie Release Dates.</dt>  
    <dd>When the League Creator is creating their League Movie Roster the movie catalogue has to be selected from 
    the DigFilm Master Movie List.  The separation of their films earliest to latest release date can be equal to
     or greater than 4 months AND less than or equal to 12 months ( 4 ≤ n ≤ 12 ) months.  
     So as the League Creator is selecting their films in addition to ensuring that they have selected a 
     minimum of 40 films, but no more than 100 films, the earliest to latest release date must span from 4 
     months to 12 months.  If all 40 films release dates take place in the same month then this will NOT satisfy 
     this rule requirement.  There must be a separation of at least 4 months from two of the film release dates, 
     but no more than 12 months.  This is relative to the date of when the League was created.</dd>
     <dt>Final Auction Date to Movie Roster Earliest Release date separation. </dt> 
     <dd>There must be at least a 2 week window separation from when the Movie Auction is completed 
     and the earliest release date from the movie Movie Auction Roster.  
     Example: if the Auction is to be completed on the 1st of August with the final bids placed, the League's 
     Movie Roster  earliest film has to have a 2 week or more release date from the 1st of August.  
     This is to ensure that there is NO overlap with the Auction which may last over several weeks and the 
     release date of films.  In summary, films should not be in the box-office, whilst they are being bided on 
     during an auction.  This also give me opportunity to resolve any Auction bid related issues reported 
     by the user.</dd>
     <dt>Auction Movie Order.</dt>  
     <dd>Once the League Creator has selected the films that will be listed in the League Movie and League 
     Auction Roster, the order of which films that will be offered for bid will be set by DigFilm program.  
     Films are presented in a randomized order AND in groups of 10's.  So if there are 100 films in the 
     League's Movie Roster, a randomizer will be used to shuffle the films and they will then be grouped 
     into 10's to be presented to the players for Auction.  This will be presented on the User's Auction 
     Dashboard, all 100 films.  However, the films that have been grouped into 10 will be presented first 
     ( in sequential order by their release date).   A column will be associated with each film, and a green-box indicates that this film, or set of 10 films are currently biddable or active.  The remaining 90 films will have a red-check box to indicate that they are inactive.  A countdown timer will be presented (League creator can choose between 6 hr, 24 hr, 48 hr) for each group of 10 films.  The countdown will indicate how long each player has to bid on each film in the Active group.  Once the timer expires, the next randomize group of 10 films are presented and are marked with a green box to indicate that their active.  This process will continue until the last group of 10 films are bided on.  Any film that has not bided on can be randomized and grouped if applicable so that the Users will have an additional opportunity to get rid of their ENTIRE balance (ideally, a user should have a balance of 0.00 USD indicating that they have exhausted all of the funds).
     </dd>
     <dt>Auction Duration:</dt>
     <dd>Since the Auctions are presented in a randomize group of 10, a countdown timer is required to indicate how long each player has to bid on the films in the Active group.  This countdown timer should be presented on the Auction Dashboard.  However, the League Creator has the opportunity to choose the duration.   During the Create League option, the League Creator can, from a pull down menu choose the following: 6 hr, 24 hr, or 48 hrs.  These options represent the time that will be granted to each player to bid on each group of 10 films.  So for a League Movie and Auction Roster that consist of 100 films, there will be 10 separate groups, with 10 films per group (plus an additional group that consist of films that were not bided on), and if the League Creator has set a countdown timer of 48 hrs, then the duration of the entire Auction could last for a period of 20 days.</dd>
    </dl>
@endsection