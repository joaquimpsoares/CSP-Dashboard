<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Reseller;
use Illuminate\Http\Request;

class ResellerController extends Controller
{

    public function getCustomersFromReseller(Reseller $reseller) {
        dd($reseller);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
        * Begin of User Level Validation
        */

        $user = \Auth::user();

        switch ($user->userLevel->name) {
            case config('app.super_admin'):
                $resellers = Reseller::whereNull('main_office')->with(['country', 'subResellers', 'status'])->get();
                break;
            
            case config('app.admin'):
                $resellers = Reseller::whereNull('main_office')->with(['country', 'subResellers', 'status'])->get();
                break;
            
            case config('app.provider'):
                $resellers = $user->provider->resellers()->whereNull('main_office')->with(['country', 'subResellers', 'status'])->orderBy('company_name')->get();
                break;
            
            /*case config('app.admin'):
                $resellers = Reseller::with('country')->orderBy('company_name')->get();
                break;*/
            
            default:
                return abort(403, __('errors.unauthorized_action'));
                break;
        }

        /**
        * End of User Level Validation
        */
        
        return view('reseller.index', compact('resellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) { }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reseller  $reseller
     * @return \Illuminate\Http\Response
     */
    public function show(Reseller $reseller) { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reseller  $reseller
     * @return \Illuminate\Http\Response
     */
    public function edit(Reseller $reseller) { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reseller  $reseller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reseller $reseller) { }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reseller  $reseller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reseller $reseller) { }
}
