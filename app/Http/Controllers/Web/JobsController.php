<?php

namespace App\Http\Controllers\web;


use App\Jobs;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Jobs\Failedjobs;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;
use romanzipp\QueueMonitor\Models\Monitor;

class JobsController extends Controller
{

    public $jobs;

    public function __construct(Jobs $jobs)
    {
        $this->jobs = $jobs;

    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        {
            $data = $request->validate([
                'only_failed' => ['nullable'],
            ]);

            $filters = [
                'onlyFailed' => (bool) Arr::get($data, 'only_failed'),
            ];

            $jobs = Monitor::query()
                ->when($filters['onlyFailed'], static function (Builder $builder) {
                    $builder->where('failed', 1);
                })
                ->ordered()
                ->paginate(
                    config('queue-monitor.ui.per_page')
                )
                ->appends(
                    $request->all()
                );

                $failedJobs= DB::table('failed_jobs')->get();

            return view('job.index', [
                'jobs' => $jobs,
                'filters' => $filters,
                'failedJobs' => $failedJobs,
            ]);
        }
        // $jobs =  $this->jobs->get();

        // $order = [];
        // $data = [];

        // foreach($jobs as $payload){
        //     $payload_json = json_decode( $payload->payload );
        //     $data = unserialize( $payload_json->data->command );
        //     $order[$payload->id] = $data->order;

        // }

        // $running = $jobs->count();

        // $failedJobs = DB::table('failed_jobs')->get();

        // return view('job.index', compact('jobs','failedJobs','running','order'));

    }

    public function getPayload(){
        return $this->payload->map(function($item){
            return unserialize($item);
        });
    }


    public function notifications()
    {
        $data = Auth::user()->unreadnotifications->data();

        return view('layouts.nav', compact('data'));
    }

    public function retryJob($id){

       Artisan::call('queue:retry ' . $id);

       return redirect()->route('jobs')->with(['alert' => 'success', 'message' => trans('messages.jobrescheduled')]);

    }

    public function runqueue(){

        Artisan::call('queue:listen --queue=PlaceordertoMS,SyncProducts,default --sleep=3 --tries=3');

        // Auth::User()->notifications->first()->markasread();

        return redirect()->route('jobs')->with(['alert' => 'success', 'message' => trans('messages.jobrescheduled')]);

     }
    public function pending(Request $request)
    {
        $jobs = $this->jobs->getPending($request->query('starting_at', -1))->map(function ($job) {
            $job->payload = json_decode($job->payload);

            return $job;
        })->values();

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
