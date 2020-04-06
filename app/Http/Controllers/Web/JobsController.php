<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class JobsController extends Controller
{

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

    public function retryJob($id){
       $tt = Artisan::call('queue:retry ' . $id);
        
        return redirect()->route('jobs')->with(['alert' => 'success', 'message' => trans('messages.jobrescheduled')]);

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
