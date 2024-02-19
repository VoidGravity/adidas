<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //using paginate
        // $products = Product::with('category')->paginate(4);
        $products = Product::with('category')->get();
        //paginate
        // $products = DB::table('products')->paginate(5);
        return view('products.index', compact('products'));
        // return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::get();
        // $product = Product::with('category')->get();

        return view('products.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        // Product::create(
        //     [
        //         'name' => $request->name,
        //         'description' => $request->description,
        //         'price' => $request->price,
        //         'tags' => $request->tags,
        //         'image_path' => $request->image_path,
        //         'category_id' => $request->category_id,
        //     ]
        // );
        // dd($request->all());
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $requestData = $request->all();
            $requestData['image_path'] = $name;
            Product::create($requestData);
            //redirect to homescrean
            return redirect()->route('product.index');
        } else {
            Product::create($request->all());
            return redirect()->url('/product');
        }
        // Product::create($request->all());
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

        // $product = Product::findorfail($id);
        // return view('products.edit', compact('product'));
        $product = Product::findorfail($id);
        $category = Category::get();
        // dd($product);
        return view('products.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        // $product= Product::findorfail($id);
        // $product->update($request->all());
        // return redirect()->back();
        // $product = Product::findorfail($id);
        // $product->update($request->all());
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $requestData = $request->all();
            $requestData['image_path'] = $name;
            $product = Product::findorfail($id);
            $product->update($requestData);
            return redirect()->back();
        } else {
            $product = Product::findorfail($id);
            $product->update($request->all());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findorfail($id);
        $product->delete();
        return redirect()->back();
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $result = Product::where('name', 'like', "%" . $search . "%")->get();
        return view('products.search', compact('result'));
    }
    public function liveSearch(Request $request)
    {
        $search = $request->search;
        $products = Product::where('name', 'like', '%' . $search . '%')->get();

        $output = '';
        foreach ($products as $key => $product) {
            $output .= '<tr>' .
                '<td>' . ($key + 1) . '</td>' .
                '<td>' . $product->name . '</td>' .
                '<td><img src="' . asset('images/' . $product->image_path) . '" alt="image" style="width: 100px; height: 100px;"></td>' .
                '<td>' . $product->description . '</td>' .
                '<td>' . $product->category->name . '</td>' .
                '<td>' . $product->price . '</td>' .
                '<td>' . $product->tags . '</td>' .
                '<td>' .
                '<a href="' . url('product/' . $product->id . '/delete') . '" class="btn btn-danger">Delete</a>' .
                '<a href="' . url('product/' . $product->id . '/edit') . '" class="btn btn-primary">Edit</a>' .
                '</td>' .
                '</tr>';
        }

        return response()->json($output);
    }
    public function liveFilter(Request $request)
    {
        $search = $request->search;
        $categoryId = $request->category_id;

        $products = Product::where('price', '<=', $search)
            ->orWhere('category_id', $categoryId)
            ->get();


        return view('products.index', compact('products'));
    }



    // public function liveFilter(Request $request)
    // {
    //     //product and category
    //     $search = $request->search;
    //     $products = Product::where('price', '<=',  $search)->get();
    //     return view('products.index', compact('products'));
    // }
}
