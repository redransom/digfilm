<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\League;

class StartAuction extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'auction:start';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Set the start date for current auctions.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		$leaguesToReview = League::whereNull('auction_start_date')->get();

        //need to make sure each league has rules!
        foreach ($leaguesToReview as $league) {
            
            if (!is_null($league->rule)) {
                //ok we have rules find out the number of players
                $player_count = $league->players->count();
                $rules = $league->rule;
                
                if ($player_count >= $rules->min_players && $player_count <= $rules->max_players) {
                    $start_time = $rules->start_time;
                    $time_to_start = time() + (60 * 60 * 4); //60 secs * 60 mins * 4 = 4hours
                    //echo "Time dif: $time_to_start - ".strtotime($start_time) . "<br/>";
                    if ($time_to_start > strtotime($start_time)) {
                        //the new date is no good so set the time for the next day
                        $league->auction_start_date = date("Y-m-d G:i:s", strtotime('+1 day', strtotime((date("Y-m-d")." ".$start_time))));
                    } else {
                        $auction_start_date = date("Y-m-d G:i:s", strtotime($start_time));
                        // ok we are fine to go ahead with this date today - so lets set the time to it
                        $league->auction_start_date = $auction_start_date;
                    }
                    $league->save();
                    var_dump($league);
                } else {
                    //TODO: Send out reminder to league players to find more players to get involved
                }
            }
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			//['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
