<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class JobsController extends Controller
{

    public $jobs;

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $jobs =  DB::table('jobs')->get();
        // dd($jobs);
        $failedJobs = DB::table('failed_jobs')->get();
        // dd($failedJobs);
        return view('job.index', compact('jobs','failedJobs'));
        
    }


    public function notifications()
    {
        $data = Auth::user()->unreadnotifications->data();
        dd($data);        
        return view('layouts.nav', compact('data'));
    }

    public function retryJob($id){
       
       Artisan::call('queue:retry ' . $id);

       Auth::User()->notifications->first()->markasread();
        
       return redirect()->route('jobs')->with(['alert' => 'success', 'message' => trans('messages.jobrescheduled')]);

    }


    public function pending(Request $request)
    {
        $jobs = $this->jobs->getPending($request->query('starting_at', -1))->map(function ($job) {
            $job->payload = json_decode($job->payload);

            return $job;
        })->values();

            dd($jobs);
        return [
            'jobs' => $jobs,
            'total' => $this->jobs->countRecent(),
        ];
    }



        /**
     * Decode the given job.
     *
     * @param  object  $job
     * @return object
     */
    protected function decode($job)
    {
        $job->payload = json_decode($job->payload);
        return $job;
    }

    public function getAddons($jobs){
        return $this->$jobs->map(function($job){
            return unserialize($job);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('failed_jobs')->where('id', $id)->delete();
    
        return redirect()->route('job')->with(['alert' => 'success', 'message' => trans('messages.importproducts')]);

    }
}
