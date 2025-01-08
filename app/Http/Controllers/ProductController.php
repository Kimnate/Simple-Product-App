<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    protected $productsFile = 'products.json';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = $this->readFile();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string',
            'stock_qty' => 'required|integer|min:0',
            'price_per_pc' => 'required|numeric|min:0',
        ]);

        $data = $this->readFile();

        $validated['date_time'] = now();
        $validated['total_value'] = $validated['stock_qty'] * $validated['price_per_pc'];

        $data[] = $validated;

        $this->writeFile($data);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'data' => $validated]);
        }

        return redirect()->route('products.index');
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
        //
        $products = $this->readFile();
        $product = $products[$id] ?? null;

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        return view('edit_product', compact('product', 'index'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string',
            'stock_qty' => 'required|integer|min:0',
            'price_per_pc' => 'required|numeric|min:0',
        ]);

        $data = $this->readFile();

        // Ensure the record exists
        if (!isset($data[$id])) {
            return response()->json(['status' => 'error', 'message' => 'Item not found'], 404);
        }

        // Update the record
        $validated['date_time'] = now();
        $validated['total_value'] = $validated['stock_qty'] * $validated['price_per_pc'];

        $data[$id] = $validated;

        // Save the updated data
        $this->writeFile($data);

        return response()->json(['status' => 'success', 'data' => $validated, 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // Protected/Private Methods to read data from file
    protected function readFile()
    {
        if (!Storage::exists($this->productsFile)) {
            return [];
        }

        $content = Storage::get($this->productsFile);

        return json_decode($content, true) ?? [];
    }

    // Method to write data to the file
    protected function writeFile(array $data)
    {
        Storage::put($this->productsFile, json_encode($data, JSON_PRETTY_PRINT));
    }

}
