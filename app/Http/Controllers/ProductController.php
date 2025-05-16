<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\Product; 
use App\Http\Requests\StoreProductRequest; 
use App\Http\Requests\UpdateProductRequest; 
use Illuminate\View\View; 
use Illuminate\Http\RedirectResponse; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class ProductController extends Controller 
{ 
    /** 
     * Display a listing of the resource. 
     */ 
    public function index(): View 
    { 
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products')); 
    } 
 
    /** 
     * Show the form for creating a new resource. 
     */ 
    public function create(): View 
    { 
        return view('products.create'); 
    } 
 
    /** 
     * Store a newly created resource in storage. 
     */ 
    public function store(StoreProductRequest $request): RedirectResponse 
    { 
        $data = $request->validated();
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $fileName, 'private');
            $data['file_path'] = 'products/' . $fileName;
        }
        
        Product::create($data);
 
        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.'); 
    } 
 
    /** 
     * Display the specified resource. 
     */ 
    public function show(Product $product): View 
    { 
        return view('products.show', compact('product')); 
    } 
 
    /** 
     * Show the form for editing the specified resource. 
     */ 
    public function edit(Product $product): View 
    { 
        return view('products.edit', compact('product')); 
    } 
 
    /** 
     * Update the specified resource in storage. 
     */ 
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse 
    { 
        $data = $request->validated();
        
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($product->file_path) {
                Storage::disk('private')->delete($product->file_path);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $fileName, 'private');
            $data['file_path'] = 'products/' . $fileName;
        }
        
        $product->update($data);
 
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.'); 
    } 
 
    /** 
     * Remove the specified resource from storage. 
     */ 
    public function destroy(Product $product): RedirectResponse 
    { 
        // Delete file if exists
        if ($product->file_path) {
            Storage::disk('private')->delete($product->file_path);
        }
        
        $product->delete();
 
        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.'); 
    } 

    public function downloadFile(Product $product)
    {
        if (!$product->file_path || !Storage::disk('private')->exists($product->file_path)) {
            abort(404);
        }

        return Storage::disk('private')->download($product->file_path);
    }
}