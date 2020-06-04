<?php

namespace App\Http\Controllers;

use App\Sum;
use App\Event;
use Session;
use Purifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserPlayRequest;

class SumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sum  $sum
     * @return \Illuminate\Http\Response
     */
    public function show(Sum $sum)
    {
        dd('show');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sum  $sum
     * @return \Illuminate\Http\Response
     */
    public function edit(Sum $sum)
    {
        dd('okay');
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sum  $sum
     * @return \Illuminate\Http\Response
     */
    public function update(UserPlayRequest $request, Sum $sum)         
    {
        if ( $sum->time == null ) { $sum->time = 0; }
        if ( $request->answer == $sum->table*$sum->number ) {
            // answer is okay
            $sum->answer = $request->answer;
            $sum->result = 1; //true
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
            $event = Event::where('id', $sum->event_id)->firstOrFail();
            $event->status+= 1;
            $event->save();
            return redirect('/play/'.$sum->event_id);
        }
        else {
            // answer is fault
            $sum->answer = $request->answer;
            $sum->faults+= 1;
            $sum->save();
            //when 3 times fault
            if ($sum->faults > 3) {
                $event = Event::where('id', $sum->event_id)->firstOrFail();
                $event->status+= 1;
                $event->save();
                $sum->result = 0;  //false
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
                return redirect('/play/'.$sum->event_id);
            }
        }
        //when fault and less then 3 times
        $event = Event::where('id', $sum->event_id)->firstOrFail();
        $countmysums = Sum::where('event_id', $sum->event_id )->where('result', '!=' , '2' )->count()+1;
        $whichtables = $event->tables;
        $totalsums = $event->totalsums;
        //write the time
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
        //refresh the timer
        $starttime = Carbon::now();
        $time = date('Y-m-d H:i:s');
        Session::put('starttime', $time);
        //fault message
        if ($sum->faults == 1 ) {
            $message = "Het antwoord is fout, probeer het nog een keer";
            } elseif ($sum->faults ==2 ) {
                $message = "Het antwoord is fout, tweede herkansing";
            } else {
                $message = "Het antwoord is fout, laatste herkansing";
            }     
            
        return view('sums.play', compact('sum', 'whichtables', 'countmysums', 'totalsums', 'message'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sum  $sum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sum $sum)
    {
        //
    }


} //endclass
