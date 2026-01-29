@extends('layouts.app')

@section('content')
<h2>商品一覧</h2>

<a href="{{ url('/products/register') }}">＋商品を追加</a>

<form action="{{ url('/products/search') }}" method="get" style="margin-top:10px;">
    <input type="text" name="keyword" placeholder="検索キーワード">
    <button type="submit">検索</button>
</form>

<div style="margin-top:10px;">
    <span>価格順で表示:</span>
    <select name="sort">
        <option value="asc">安い順</option>
        <option value="desc">高い順</option>
    </select>
</div>

<hr>

@foreach($products as $product)
<div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
    <img src="{{ asset('images/products/' . $product['image']) }}" alt="{{ $product['name'] }}" width="100">

    <h3>{{ $product['name'] }}</h3>
    <p>¥{{ number_format($product['price']) }}</p>
</div>
@endforeach

{{ $products->links() }}
@endsection
