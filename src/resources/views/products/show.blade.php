@extends('layouts.app')

@section('content')
<h2>商品詳細</h2>

<form action="{{ url('/products/update/' . $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf

    {{-- 商品画像 --}}
    <div>
        <a href="{{ url('/products') }}" class="breadcrumb-link">商品一覧</a> ＞ {{ $product->name }}

        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" width="150"><br>

        {{-- 画像変更 --}}
        <input type="file" name="image">
    </div>

    {{-- 商品名 --}}
    <div>
        <label>商品名</label><br>
        <input type="text" name="name" value="{{ $product->name }}">
    </div>

    {{-- 価格 --}}
    <div>
        <label>値段</label><br>
        <input type="text" name="price" value="{{ $product->price }}">
    </div>

    {{-- 季節 --}}
    <div>

        <label>季節</label><br>

        @php
        $allSeasons = ['春' => 1, '夏' => 2, '秋' => 3, '冬' => 4];
        // この商品に紐付いた季節IDを配列に変換
        $productSeasonIds = $product->seasons->pluck('id')->toArray();
        @endphp

        @foreach($allSeasons as $name => $id)
        <label>
            <input type="checkbox" name="seasons[]" value="{{ $id }}"
                @if(in_array($id, $productSeasonIds)) checked @endif>
            {{ $name }}
        </label>
        @endforeach
    </div>

    {{-- 商品説明 --}}
    <div>
        <label>商品説明</label><br>
        <textarea name="description" rows="4">{{ $product->description }}</textarea>
    </div>

    <br>

    {{-- 戻るボタン --}}
    <button type="button" onclick="history.back()">戻る</button>


    {{-- 保存ボタン --}}
    <button type="submit">変更を保存</button>
</form>
@endsection