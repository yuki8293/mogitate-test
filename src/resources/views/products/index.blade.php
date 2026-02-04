@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="product-index">

    @if(!empty($keyword))
    <h2 class="page-title">"{{ $keyword }}"の商品一覧</h2>
    @else

    <div class="product-area">
        <div class="product-area__header">
            <h2 class="page-title">商品一覧</h2>
            @endif

            {{-- 上部操作エリア --}}
            <div class="product-index__actions">

                <a href="{{ url('/products/register') }}" class="add-product-btn">＋商品を追加</a>

                <div class="sidebar">
                    <form action="{{ url('/products/search') }}" method="get" style="margin-top:10px;">
                        <input type="text" name="keyword" placeholder="検索キーワード">
                        <button type="submit">検索</button>
                    </form>

                    <div style="margin-top:10px;">
                        <form method="get" action="{{ url('/products') }}">
                            <span>価格順で表示:</span>
                            <select name="sort" onchange="this.form.submit()">
                                <option value="" {{ request('sort') == null ? 'selected' : '' }}>
                                    価格で並び替え
                                </option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>安い順に表示</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
                            </select>
                        </form>
                    </div>

                    @if(!empty($currentSort))
                    <div class="sort-history" id="sort-history">

                        <span>
                            {{ $currentSort == 'asc' ? '安い順' : '高い順' }} に表示
                        </span>

                        <a href="{{ url('/products') }}">×</a>

                    </div>
                    @endif

                    {{-- 商品一覧 --}}
                    <div class="product-list">

                        @foreach($products as $product)
                        <a href="{{ url('/products/detail/' . $product->id) }}" class="product-card">

                            <div class="product-card__inner">

                                <img src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-card__image">


                                <h3 class="product-card__name">{{ $product->name }}</h3>
                                <p class="product-card__price">¥{{ number_format($product->price) }}</p>

                            </div>
                        </a>
                        @endforeach
                    </div>

                    {{-- ページネーション --}}
                    <div class="pagination-wrapper">
                        @for($i = 1; $i <= $products->lastPage(); $i++)
                            <a href="{{ $products->url($i) }}"
                                class="page-link {{ $products->currentPage() == $i ? 'active' : '' }}">
                                {{ $i }}
                            </a>
                            @endfor
                    </div>
                    @endsection