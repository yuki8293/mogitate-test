<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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

    public function store(Request $request)
    {

        $request->validate([
            'name'        => 'required|max:255',                     // 商品名：必須
            'price'       => 'required|integer|min:0|max:10000',    // 値段：必須、数値型、0~10000円
            'image'       => 'required|file|mimes:png,jpeg',        // 商品画像：アップロード必須、拡張子 png/jpeg
            'season'      => 'required',                             // 季節：選択必須
            'description' => 'required|max:120',                    // 商品説明：必須、最大120文字
        ]);

        // 画像アップロード（storage/app/public/products に保存）
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }

        // 2️⃣ products テーブルに保存
        $product = \App\Models\Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'image'       => $$imagePath,
            'description' => $request->description,
        ]);

        // 3️⃣ product_season 中間テーブルに保存
        $product->seasons()->attach($request->season);

        // 4️⃣ 一覧画面にリダイレクト
        return redirect('/products')->with('success', '商品を登録しました！');
    }

    public function update(Request $request, $productId) {

        $request->validate([
            'name'        => 'required|max:255',
            'price'       => 'required|integer|min:0|max:10000',
            'image'       => 'required|file|mimes:png,jpeg', // 必須の場合
            'season'      => 'required',
            'description' => 'required|max:120',
        ]);
    }

    public function destroy($productId) {}
}
