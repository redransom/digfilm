<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Genre;
use App\Models\SiteContent;
use App\Models\Movie;
use App\Models\Auction;
use Auth;
use App\Models\User;
use DB;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		/*
		 * Need:
		 * 1) Most recent top 3 movies added.
		 * 2) Top 3 most recent released movies.
		 * 3) Top 3 auctioned movies
		*/
		/* $new_movies = Movie::where('created_at', '>', date("Y-m-d", strtotime("-1 month")))
			->orderBy('created_at', 'DESC')->limit(3)->get();

		$released_movies = Movie::where('release_at', '>', date("Y-m-d", strtotime("-1 month")))
			->orderBy('release_at', 'DESC')->limit(3)->get();

		
		$auctions = Auction::select(DB::raw('count(movies_id) as auction_count, movies_id'))
				->groupBy('movies_id')
				->limit(3)
				->orderBy('auction_count', 'DESC')
				->lists('movies_id');

		$top_auctions = Movie::whereIn('id', $auctions)->get();*/

		//top 3 news articles
		$news_articles = SiteContent::articles();

		$genres = Genre::all();

		$contact_footer = SiteContent::section('COF');
		$contact_rhs = SiteContent::section('CRS');

		$data = ['genres_list'=> $genres,
				'news_articles' => $news_articles,
				'contact_footer' => $contact_footer,
				'contact_rhs' => $contact_rhs,
				/*'new_movies'=> $new_movies,
				'released_movies'=> $released_movies,
				'top_auctions'=> $top_auctions*/];

		view()->share($data);

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
