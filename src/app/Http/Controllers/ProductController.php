<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index()
    {
        $allProducts = [
            ['id' => 1, 'name' => 'キウイ', 'price' => 800, 'image' => 'kiwi.png'],
            ['id' => 2, 'name' => 'バナナ', 'price' => 600, 'image' => 'banana.png'],
            ['id' => 3, 'name' => 'オレンジ', 'price' => 850, 'image' => 'orange.png'],
            ['id' => 4, 'name' => 'スイカ', 'price' => 700, 'image' => 'watermelon.png'],
            ['id' => 5, 'name' => 'ピーチ', 'price' => 1000, 'image' => 'peach.png'],
            ['id' => 6, 'name' => 'シャインマスカット', 'price' => 1400, 'image' => 'muscat.png'],
            ['id' => 7, 'name' => 'パイナップル', 'price' => 800, 'image' => 'pineapple.png'],
            ['id' => 8, 'name' => 'ストロベリー', 'price' => 1200, 'image' => 'strawberry.png'],
            ['id' => 9, 'name' => 'メロン', 'price' => 900, 'image' => 'melon.png'],
            ['id' => 10, 'name' => '巨峰', 'price' => 1100, 'image' => 'grapes.png'],
        ];

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 6;
        $currentItems = array_slice($allProducts, ($currentPage - 1) * $perPage, $perPage);
        $paginatedProducts = new LengthAwarePaginator(
            $currentItems,
            count($allProducts),
            $perPage,
            $currentPage,
            ['path' => url('/products')]
        );

        return view('products.index', ['products' => $paginatedProducts]);
    }

    public function search(Request $request) {}

    public function show($productId) {}

    public function create() {}

    public function store(Request $request) {}

    public function update(Request $request, $productId) {}

    public function destroy($productId) {}
}
