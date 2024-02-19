<?php

namespace App\Http\Controllers;

use App\Models\permissions;
use App\Models\route;
use Illuminate\Http\Request;

class permissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = route::paginate(5);
        return view('permission.index',compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'route' => 'required',
        ]);
        $route = new route();
        $route->route = $request->route;
        $route->save();
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = route::find($id);
        return view('permission.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'route' => 'required',
        ]);
        $route = route::find($id);
        $route->route = $request->route;
        $route->save();
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $route = route::find($id);
        $route->delete();
        return redirect()->route('permission.index');
    }
}
