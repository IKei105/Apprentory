<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Original_product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $result = $this->productService->index();
        return view('products.index', [
            'products' => $result['products'],
            'popularTags' => $result['popularTags']
        ]);
    }

    public function indexTag($id)
    {
        $result = $this->productService->getProductsByTag($id);
        return view('products.index', [
            'products' => $result['products'],
            'popularTags' => $result['popularTags']
        ]);
    }

    public function create()
    {
        return view('products.create2');
    }

    public function store(Request $request)
    {
        $data = $request->only(['element', 'title', 'subtitle', 'product_detail', 'product_url', 'github_url']);

        $tags = [];
        for ($i = 1; $i <= 5; $i++) {
            $key = "tag_select{$i}";
            if ($request->filled($key)) {
                $tags[] = $request->$key;
            }
        }
        $data['tags'] = $tags;

        $images = $request->file('images', []);

        $product = $this->productService->store($data, $images);
        return redirect()->route('products.show', ['product' => $product->id]);
    }

    public function show(string $id)
    {
        $result = $this->productService->show($id);
        if (!$result) return redirect()->route('login');

        return view('products.show', [
            'product' => $result['product'],
            'profile' => $result['user']->profile,
            'isFollow' => $result['isFollow'],
            'user' => $result['product']->profile->user
        ]);
    }

    public function edit(string $id)
    {
        $result = $this->productService->edit($id);
        if (!$result) return redirect()->route('products.index');

        return view('products.edit2', [
            'product' => $result['product'],
            'technologieIds' => $result['technologieIds']
        ]);
    }

    public function update(Request $request, string $id)
    {
        $product = Original_product::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'product_detail' => 'required|string',
            'product_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'element' => 'required|string|in:need-tester,need-review',
        ]);

        $tags = [];
        for ($i = 1; $i <= 5; $i++) {
            $select = "tag_select{$i}";
            if ($request->filled($select)) {
                $tags[] = $request->$select;
            }
        }

        $requestData = [
            'tags' => $tags,
            'deleted_image_ids' => $request->input('deleted_image_ids', []),
            'existing_image_ids' => $request->input('existing_image_ids', []),
            'images' => $request->file('images', [])
        ];

        $this->productService->update($validated, $product, $requestData);

        return redirect()->route('products.show', ['product' => $product->id])
            ->with('success', '更新が完了しました！');
    }

    public function destroy(string $id)
    {
        $this->productService->destroy($id);
        return redirect()->route('products.index')->with('success', '投稿が削除されました。');
    }
}
