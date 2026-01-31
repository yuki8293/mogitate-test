@extends('layouts.app')

@section('content')

@if(!empty($keyword))
<h2>"{{ $keyword }}"の商品一覧</h2>
@else
<h2>商品一覧</h2>
@endif

<a href="{{ url('/products/register') }}">＋商品を追加</a>

<form action="{{ url('/products/search') }}" method="get" style="margin-top:10px;">
    <input type="text" name="keyword" placeholder="検索キーワード">
    <button type="submit">検索</button>
</form>

<div style="margin-top:10px;">
    <form method="get" action="{{ url('/products') }}">
        <span>価格順で表示:</span>
        <select name="sort" onchange="this.form.submit()">
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>安い順に表示</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
        </select>
    </form>
</div>

@if(!empty($currentSort))
<div id="sort-history" style="display:flex; justify-content:space-between; align-items:center; border:1px solid #ccc; padding:5px 10px; margin-top:10px; background-color:#f9f9f9;">
    <span>
        {{ $currentSort == 'asc' ? '安い順' : '高い順' }} に表示
    </span>

    <button type="button" onclick="document.getElementById('sort-history').style.display='none'" style="border:none; background:none; font-weight:bold; cursor:pointer;">×</button>
</div>
@endif

<hr>

@foreach($products as $product)
<a href="{{ url('/products/detail/' . $product->id) }}" style="text-decoration:none; color:inherit;">

    <div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" width="100">

        <h3>{{ $product->name }}</h3>
        <p>¥{{ number_format($product->price) }}</p>
    </div>
</a>
@endforeach

{{ $products->links() }}
@endsection