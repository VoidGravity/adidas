<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Route;
use Illuminate\Http\Request;

class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::with('routes')->get();
        return view('role.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Route::all();
        return view("role.create",compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'role' => 'required',
        //     'route' => 'required',
        // ]);

        $role=Role::create([
            'name' => $request->name,
        ]);
        // RolePermission::create([
        //     'role_id' => $role->id,
        //     'route_id' => $request->route_id,
                
        // ]);
        foreach ($request->route_id as $routeId) {
            
                RolePermission::create([
                    'role_id' => $role->id,
                    'route_id' => $routeId,
                ]);
            
        }
        // $permissions = new ROU();
        // $permissions->route = $request->route;
        // $permissions->save();
        return redirect()->route('role.index');
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
        $data = Role::find($id);
        $permissions = Route::all();
        return view('role.edit',compact('data','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        RolePermission::where('role_id',$id)->delete();
        foreach ($request->route_id as $routeId) {
            
            RolePermission::create([
                'role_id' => $role->id,
                'route_id' => $routeId,
            ]);
        
    }
        return redirect()->route('role.index');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('role.index');
    }
}
