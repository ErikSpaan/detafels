<?php

namespace App\Http\Controllers;

use App\Event;
use App\Sum;
use Purifier;
use auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreationRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreationRequest $request)
    {
        $tables = "";
        $totalsums = 0;
        // make a string of the selected tables
        for ( $i=1; $i<=10; $i++) {
            if ($request->{"table{$i}"} == true ) {
               $tables = $tables . strval($i) . ',';
                $totalsums += 10;
            }
        };
        //check if there is a selection made for the tables
        if ($totalsums == 0 ) {
            $tables = "1,2,3,4,5,6,7,8,9,10,";
            $totalsums = 100;
        }
        $tables = substr($tables, 0, -1);
        // save the event
        $event = new Event();
        $event->user_id = Auth::User()->id;
        $event->tables = $tables; 
        $event->selectorder = Purifier::clean($request->selectorder);
        //$event->timelimit = Purifier::clean(request('timelimit'));
        $event->timelimit = 0;
        $event->totalsums = $totalsums; 
        $event->status = 0;  //percentage
        $event->finished = 0; //boolean
        $event->save();

        // load the selected sums in the database
        $sums = Sum::where('event_id', $event->id )->first(); // to check if there are already sums loaded in database
        $mytables = explode(',', $event->tables);
        if (!$sums) {
            foreach ($mytables as $mytable) {
                for ( $i=1; $i<=10; $i++ ) {
                    $newsum = new Sum();
                    $newsum->event_id = $event->id;
                    $newsum->table = $mytable;
                    $newsum->number = $i;
                    $newsum->time = 0;
                    $newsum->save();
                } //end for
            } //end foreach
        }
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
