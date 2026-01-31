<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 並び替え
        $sort = $request->get('sort');
        if ($sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        // ページネーション
        $products = $query->paginate(6)->appends(['sort' => $sort]);

        return view('products.index', [
            'products' => $products,
            'currentSort' => $sort
        ]);
    }

    public function search(Request $request)
    {

        $keyword = $request->get('keyword');

        $query = Product::query();

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = $query->paginate(6)->appends([
            'keyword' => $keyword
        ]);

        return view('products.index', [
            'products' => $products,
            'currentSort' => null,
            'keyword' => $keyword
        ]);
    }

    public function show($productId) {

        $product = Product::findOrFail($productId);
        return view('products.show', compact('product'));
    }

    public function create()
    {

        $seasons = \App\Models\Season::all(); // 季節マスタを取得
        return view('products.register', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {

        $validated = $request->validated();

        // 画像アップロード（storage/app/public/products に保存）
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }

        // products テーブルに保存
        $product = \App\Models\Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'image'       => $imagePath,
            'description' => $validated['description'],
        ]);

        // product_season 中間テーブルに保存
        $product->seasons()->attach($validated['season']);

        // 一覧画面にリダイレクト
        return redirect('/products')->with('success', '商品を登録しました！');
    }

    public function update(ProductUpdateRequest $request, $productId) {

        $validated = $request->validated();

        $product = Product::findOrFail($productId);
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();
        $product->seasons()->sync($validated['seasons']);

        return redirect('/products')
            ->with('success', '商品情報を更新しました');
    }

    public function destroy($productId) {}
}
