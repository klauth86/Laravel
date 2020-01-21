<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;

use Illuminate\Support\Facades\DB;
use App\SearchQuery;
use App\Event;
use App\Position;
use App\AccountRef;
use App\Account;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	// Login
	
	public function HasSessionData($key = 'id')
	{
		return Session::has($key);
	}
	
	public function GetSessionData($key = 'id')
	{
		return Session::get($key);
	}
	
	public function SetSessionData($value, $key = 'id')
	{
		Session::put($key, $value);
	}
	
	public function ClearSessionData($key = 'id')
	{
		Session::forget($key);
	}	
	
	public function commonStep1Logic()
	{
		if ($this->HasSessionData())
		{
			$squeries = SearchQuery::where('facebook_login', $this->GetSessionData())->get();
			
			if ($squeries->isEmpty())
			{		
				$events = Event::where('is_active', 1)->get()->toArray();
				$eventsKvps = array_column($events, 'description', 'id');
				
				$positions = Position::where('is_active', 1)->get()->toArray();
				$positionsKvps = array_column($positions, 'description', 'id');
				
				return view('welcome.step1')->with('events', $eventsKvps)->with('positions', $positionsKvps);	
			}			
			return $this->commonStep2Logic();
		}		
		return view('welcome.index');
	}
	
	public function commonStep2Logic()
	{
		if ($this->HasSessionData())
		{
			$refs = AccountRef::where('facebook_login', $this->GetSessionData())->get();
			
			if ($refs->isEmpty())
			{
				return view('welcome.step2');
			}
			return $this->commonMainLogic();
		}		
		return view('welcome.index');
	}
	
	public function IsTelegram($reference)
	{
		return false;
	}
	
	public function commonMainLogic()
	{
		$account = Account::with('searchQueries')->with('accountRefs')->where('facebook_login', $this->GetSessionData())->first();
		$currentSearch = $account->searchQueries->where('is_active', 1)->first();
		
		$fittedLogins = DB::table('t_orm_search_query')->where('is_active', 1)->where('search_position_id', $currentSearch->self_position_id)
		->where('self_position_id', $currentSearch->search_position_id)->where('event_id', $currentSearch->event_id)->pluck('facebook_login');
		
		$accounts = Account::with('accountRefs')->whereIn('facebook_login', $fittedLogins)->simplePaginate(1);		
		return view('main.index')->with('accounts', $accounts);
	}
	
	public function commonMainSettings()
	{
		$account = Account::with('searchQueries')->with('accountRefs')->where('facebook_login', $this->GetSessionData())->first();

		$events = Event::where('is_active', 1)->get()->toArray();
		$eventsKvps = array_column($events, 'description', 'id');

		$positions = Position::where('is_active', 1)->get()->toArray();
		$positionsKvps = array_column($positions, 'description', 'id');

		$currentSearch = $account->searchQueries->where('is_active', 1)->first();

		return view('main.settings')->with('events', $eventsKvps)->with('positions', $positionsKvps)->with('account', $account)->with('currentSearch', $currentSearch);
	}
}
