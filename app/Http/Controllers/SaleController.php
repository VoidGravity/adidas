<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Sale::with('product', 'user')->get();
        return view('sale.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sale.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
            
        //     'quantity' => 'required',
        //     'total' => 'required',
        //     'payment_type' => 'required',
            
        // ]);
        Sale::create($request->all());
        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');

        // if (!$result) {
        //     return redirect()->route('sales.index')->with('fail', 'Something went wrong.');
        // } else {
        //     return redirect()->route('sales.index')->with('success', 'Sale created successfully.');

        // }
        
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
        $sale = Sale::findorfail($id);
        return view('sale.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     */ 
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'quantity' => 'required',
        //     'total' => 'required',
        //     'payment_type' => 'required',
        // ]);
        $sale = Sale::findorfail($id);
        $sale->update($request->all());
        return redirect('/sales');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = sale::findorfail($id);
        $sale->delete();
        return redirect('/sales');
    }    
    
}
