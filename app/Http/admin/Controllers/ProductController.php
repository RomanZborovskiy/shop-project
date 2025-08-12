<?php

namespace App\Http\admin\Controllers;

use App\Actions\Products\CreateProductAction;
use App\Actions\Products\GetProductFormDataAction;
use App\Actions\Products\UpdateProductAction;
use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function addAttribute(Request $request, Product $product)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'attribute_value_id' => 'required|exists:attribute_values,id',
        ]);

        $product->attributeValues()->attach($request->attribute_value_id);

        return back()->with('success', 'Характеристика додана');
    }
    
    public function index()
    {
        $products = Product::with(['brand', 'category'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(GetProductFormDataAction $formData)
    {
         $data = $formData->handle();

        return view('admin.products.create', $data);
    }

    public function store(ProductRequest $request, CreateProductAction $createProduct)
    {
        $createProduct->handle($request->validated(), $request);
        
        return redirect()->route('products.index')->with('success', 'Продукт успішно створено!');
    }


    public function edit(Request $request, Product $product, GetProductFormDataAction $formData)
    {
        $data = $formData->handle($request->only('attribute_id'));
        $data['product'] = $product;
        return view('admin.products.edit', $data);
    }

    public function update(ProductRequest $request, Product $product, UpdateProductAction $updateProduct)  
    {
        $$updateProduct->execute($product, $request->validated(), $request);

        return redirect()->route('products.index')->with('success', 'Продукт успішно оновлено!');
    
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success','Продукти видалено');
    }

    public function storeAttribute(Request $request, Product $product)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $product->properties()->attach($request->property_id);

        return redirect()->route('products.index')->with('success', 'Атрибут додано до продукту');
    }
}
