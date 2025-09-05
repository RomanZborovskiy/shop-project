<?php

namespace App\Http\admin\Controllers;

use App\Exports\ProductsExport;
use App\Facades\Currency;
use App\Http\admin\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\Term;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'name',
            'price_from',
            'price_to',
            'category_id',
            'has_images',
            'sort_by',
            'direction',
        ]);
        
        $products = Product::with(['brand', 'category'])->filter($filters)->paginate(10);

        foreach ($products as $product) {
            $product->prices = Currency::getPrices($product->price);
        }
        
        $categories = Category::pluck('name', 'id')->prepend('Всі', '');
        return view('admin.products.index', compact('products','categories'));
    }

    public function create(Product $product)
    {
        $brands = Brand::all()->pluck('name', 'id');
        $categories = Term::pluck('name', 'id');

        return view('admin.products.create', compact('brands','categories'));
    }

    public function store(ProductRequest $request, )
    {   
        $data = $request->validated();

        $product=Product::create($data);

        if (!empty($data['seo'])) {
            $product->seo('uk')->updateOrCreate([], [
                'tags' => $data['seo'],
                'group' => 'ua',
            ]);
        }

        $product->mediaManage($request);

        return redirect()->route('products.index');
    }



    public function edit(Request $request, Product $product)
    {
        $brands = Brand::all();
        $categories = Term::pluck('name', 'id');
        $attributes = Attribute::all();

        $properties = collect();
        if ($request->filled('attribute_id')) {
            $properties = Property::where('attribute_id', $request->attribute_id)->get();
        }

        return view('admin.products.edit', compact(
            'product',
            'brands',
            'categories',
            'attributes',
            'properties'
        ));
    }

    public function update(ProductRequest $request, Product $product)  {
        $data = $request->validated();

        $product->update($data);

        if (!empty($data['seo'])) {
            $product->seo('uk')->updateOrCreate([], [
                'tags' => $data['seo'],
                'group' => 'ua',
            ]);
        }

        $product->mediaManage($request);

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

    public function categoriesTree(Request $request)
    {
        $nodes = Term::get()->toTree();

        $traverse = function ($categories) use (&$traverse) {
            $tree = [];
            foreach ($categories as $category) {
                $tree[] = [
                    'id' => $category->id,
                    'text' => $category->name,
                    'children' => $traverse($category->children),
                ];
            }
            return $tree;
        };

        return response()->json($traverse($nodes));
    }

    public function import(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));
        return back()->with('success', 'Товари імпортовано!');
    }
    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function addAttribute(Request $request, Product $product)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'attribute_value_id' => 'required|exists:attribute_values,id',
        ]);

        $product->attributeValues()->attach($request->attribute_value_id);

        return back()->with('success', 'Характеристика додана');
    }
}
