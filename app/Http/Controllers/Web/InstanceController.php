<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Instance;
use Illuminate\Http\Request;

class InstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instances = Instance::all();

        return view('packages.microsoft.instance', compact('instances'));

        // return view('packages.microsoft.conf', compact('instances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $instances = Instance::all();

        return view('packages.microsoft.add', compact('instances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|String',
            'external_id' => 'required|String',
            'external_type' => 'required|String|in:direct,indirect',
            'external_url' => 'String'

        ]);

        Instance::create([
            'name' => $request->name,
            'provider' => 'microsoft',

            'external_id' => $request->external_id,
            'external_type' => $request->external_type,
            'external_url' => $request->external_url
        ]);

        return redirect()->route('instances.index')->with('success', 'Instance created succesfully');
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
        $instance = Instance::findOrFail($id);

        return view('packages.microsoft.edit', compact('instance'));
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
        $instance = Instance::findOrFail($id);

        $this->validate($request, [
            'name' => 'String',
            'external_id' => 'String',
            'external_type' => 'String|in:direct,indirect',
            'external_url' => 'String'
        ]);

        $instance->update([
            'name' => $request->name,
            'external_id' => $request->external_id,
            'external_type' => $request->external_type,
            'external_url' => $request->external_url
        ]);

            // dd($instance);
        $instance->update($request->all());

        return redirect()->route('instances.index')->with('success', 'Instance updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instance = Instance::findOrFail($id);

        $instance->delete();

        return redirect()->route('instances.index')->with('success', 'Instance deleted succesfully');
    }
}