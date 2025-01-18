<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = Product::query();

    if ($request->has('search')) {
        $search = $request->get('search');
        $query->where('product_id', 'like', "%$search%")
              ->orWhere('name', 'like', "%$search%")
              ->orWhere('description', 'like', "%$search%")
              ->orWhere('price', 'like', "%$search%");
    }

    if ($request->has('sort')) {
        $sort = $request->get('sort');
        $query->orderBy($sort, 'asc');
    }

    $products = $query->paginate(10);

    return view('products.index', compact('products'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'product_id' => 'required|unique:products',
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imagePath = $file->store('uploads', 'public'); // Store in 'public/uploads'
            $validated['image'] = $imagePath;
        }

        // Create the product
        Product::create($validated);

        // Redirect back to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
        
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
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Fetch product by ID or fail
        return view('products.edit', compact('product')); // Pass product to the view
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    // Validate the input
    $validated = $request->validate([
        'product_id' => 'required|unique:products,product_id,' . $id,
        'name' => 'required',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'nullable|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    // Find the product
    $product = Product::findOrFail($id);

    // Handle the new image upload
    if ($request->hasFile('image')) {
        // Delete the old image from storage
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }
        

        // Store the new image
        $file = $request->file('image');
        $imagePath = $file->store('uploads', 'public');
        $validated['image'] = $imagePath; // Update the image path
    } else {
        // Keep the existing image if no new image is uploaded
        $validated['image'] = $product->image;
    }

    // Update the product
    $product->update($validated);

    // Redirect back to the product index page with a success message
    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Redirect back to the product list with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
        
    }

}
