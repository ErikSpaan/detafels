<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Sum;
use Carbon\Carbon;
use Session;
use auth;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\UserRenewRequest;

class PagesController extends Controller
{
    public function index() {

        $events = Event::where('user_id', Auth::User()->id)->orderby('created_at', 'desc')->paginate(20);
        Paginator::useBootstrap();
       
        return view('index', compact('events'));

    } //end function


    public function play(Request $request) {

        $id = $request->event_id;
        $event = Event::where('id', $id)->firstOrFail();
        $whichtables = $event->tables;
        $countmysums = Sum::where('event_id', $id )->where('result', '!=' , '2' )->count();
        $totalsums = $event->totalsums;
        if (( $countmysums == $totalsums) && $totalsums != 0 ) {
            $event->finished = 1;
            $event->save();
            return redirect('/finished');
        } elseif ( $event->selectorder == "random" ) {
            $sum = Sum::where('event_id', $id )->where('result', '=' , '2' )->inRandomOrder()->firstOrFail(); 
        } elseif ( $event->selectorder == "reverse" ) {
            $sum = Sum::where('event_id', $id )->where('result', '=' , '2' )
                        ->orderby('table','asc')->orderBy('number','desc')->firstOrFail(); 
        } else {
            $sum = Sum::where('event_id', $id )->where('result', '=' , '2' )
                        ->orderby('table','asc')->orderBy('number','asc')->firstOrFail(); 
        }
        $countmysums++;
        $starttime = Carbon::now();
        $time = date('Y-m-d H:i:s');
        Session::put('starttime', $time);
        return view('sums.play', compact('sum', 'whichtables', 'countmysums', 'totalsums'));

    } //end function

    public function pauze(Request $request) {

        $sum = Sum::findOrFail($request->sum_id);
        if ( $sum->time == null ) { $sum->time = 0; }
        $endtime = Carbon::now();
        $starttime = Session::get('starttime');
        $duration = $endtime->diffInSeconds($starttime);
        if ($duration > 999) { 
            $duration = 999; 
            $sum->time = $duration;
        } else {
            $sum->time+= $duration;
        }
        $sum->save();

        return redirect('/');
    }

    public function finished() {
        
        return view('finished');
    }

    public function showresults(Request $request) {

        $event=Event::where('id', $request->event_id)->firstOrFail();
        $eventsums=Sum::where('event_id', $request->event_id)->get();
        $false=Sum::where('event_id', $request->event_id)->where('result', '0')->count();
        $good=Sum::where('event_id', $request->event_id)->where('result', '1')->count();
        $lastDateSum=Sum::where('event_id', $request->event_id)->latest('updated_at')->first();
        if ($lastDateSum != null ) { $lastDate = $lastDateSum->updated_at;
        } else {
            $lastDate = "onbekend";
        }
        return view('showresults', compact('eventsums', 'event', 'false', 'good', 'lastDate'));
    }

    public function nieuweopdracht(UserRenewRequest $request) {
        $tables = "";
        $totalsums = 0;
        $oldId = $request->event_id;
        $oldevent = Event::where('id' , $oldId)->firstOrFail();
        //doesn't work
        //$tableStringPosition = $oldevent->tables;
        //$oldtables = substr($oldevent->tables, 0, strpos($tableStringPosition, ":"));

        //how to load the sum database: set in the events table
        $timeframe = $request->timeframe;
        if ($request->fault == true && $request->time == false) {
            $tables = "id=".$oldevent->id.':F';
            $totalsums = Sum::where('event_id', $oldId)->where('faults', '!=', '0')->count();
            if ( $totalsums == 0 ) {
                return redirect()
                ->back()
                ->withInput()
                ->with('message', 'Er zijn geen sommen met fouten gevonden');
            }
        } else if ($request->fault == false && $request->time == true) {
            $tables = "id=".$oldevent->id.':T:'.$request->timeframe.'s';
            $totalsums = Sum::where('event_id', $oldId)
                        ->where(function ($query) use ($timeframe) {
                            $query->Where('time', '>=', $timeframe)->orWhereNull('time'); 
                            })
                            ->count();
            if ( $totalsums == 0 ) {
                return redirect()
                ->back()
                ->withInput()
                ->with('message', 'Er zijn geen sommen met tijdsoverschrijding gevonden');
            }
        } else if ($request->fault == true && $request->time == true) {
            $tables = "id=".$oldevent->id.':F:T:'.$request->timeframe.'s';
            $totalsums = Sum::where('event_id', $oldId)
                        ->where(function ($query) use ($timeframe) {
                            $query->where('faults', '!=', '0')
                                  ->orWhere('time', '>=', $timeframe)->orWhereNull('time'); 
                            })
                            ->count();
            if ( $totalsums == 0 ) {
                return redirect()
                ->back()
                ->withInput()
                ->with('message', 'Er zijn geen sommen met fouten of tijdsoverschrijding gevonden');
            }                
        } else {
            $tables = "id=".$oldevent->id.':All';
            $totalsums = Sum::where('event_id', $oldId)->count();
            if ( $totalsums == 0 ) {
                return redirect()
                ->back()
                ->withInput()
                ->with('message', 'Er zijn geen sommen gevonden');
            }      
        }
        // order selection
        if ($request->random == true) {
            $random = 1;
        } else {
            $random = 0;
        }
        // create a new event
        $event = new Event();
        $event->user_id = Auth::User()->id;
        $event->tables = $tables; 
        $event->selectorder = $request->selectorder;
        //$event->timelimit = Purifier::clean(request('timelimit'));
        $event->timelimit = 0; // not used at this moment
        $event->totalsums = $totalsums; 
        $event->status = 0;  //percentage
        $event->finished = 0; //boolean
        $event->save();

        // load the selected sums in the sums table database
        $sums = Sum::where('event_id', $event->id )->first(); // to check if there are already sums loaded in database
        if (!$sums) {
            if ($request->fault == true && $request->time == false) {
                $copysums = Sum::where('event_id', $oldId)->where('faults', '!=', '0')->get();
            } else if ($request->fault == false && $request->time == true) {
                $copysums = Sum::where('event_id', $oldId)
                                ->where(function ($query) use ($timeframe) {
                                    $query->Where('time', '>=', $timeframe)->orWhereNull('time'); 
                                })
                                ->get();
            } else if ($request->fault == true && $request->time == true) {
                $copysums = Sum::where('event_id', $oldId)
                                ->where(function ($query) use ($timeframe) {
                                    $query->where('faults', '!=', '0')
                                        ->orWhere('time', '>=', $timeframe)->orWhereNull('time'); 
                                })
                                ->get();
            } else {
                $copysums = Sum::where('event_id', $oldId)->get();
            }
            // copy the selected sums to the new event
            foreach ($copysums as $copysum) {
                $newsum = new Sum();
                $newsum->event_id = $event->id;
                $newsum->table = $copysum->table;
                $newsum->number = $copysum->number;
                $newsum->save();
            } //end foreach
        } //endif
        return redirect('/');
    } //end function

    public function logout() {
        return redirect('login')->with(Auth::logout());
    }

    public function test() {
        return view('test');
    }

} // end class
