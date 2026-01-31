@extends('layouts.app')

@section('content')
<h2>商品詳細</h2>


<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf


    {{-- 商品画像 --}}
    <div>
        <a href="{{ url('/products') }}" class="breadcrumb-link">商品一覧</a> > {{ $product->name }}

        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" width="150"><br>

        {{-- 画像変更 --}}
        <input type="file" name="image">

        <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
        </div>

    </div>

    {{-- 商品名 --}}
    <div>
        <label>商品名</label><br>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">

        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
    </div>

    {{-- 価格 --}}
    <div>
        <label>値段</label><br>
        <input type="text" name="price" value="{{ old('price', $product->price) }}">

        <div class="form__error">
            @error('price')
            {{ $message }}
            @enderror
        </div>
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

        <div class="form__error">
            @error('seasons')
            {{ $message }}
            @enderror
            @error('seasons.*')
            {{ $message }}
            @enderror
        </div>
    </div>

    {{-- 商品説明 --}}
    <div>
        <label>商品説明</label><br>
        <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>

        <div class="form__error">
            @error('description')
            {{ $message }}
            @enderror
        </div>
    </div>

    <br>

    {{-- 戻るボタン --}}
    <button type="button" onclick="location.href='{{ url('/products') }}'">戻る</button>


    {{-- 保存ボタン --}}
    <button type="submit">変更を保存</button>

    {{-- 商品削除ボタン --}}
    <form action="{{ url('/products/' . $product->id . '/delete') }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit"
            style="background:none; border:none; cursor:pointer; font-size:1.2em;"
            title="削除"
            onclick="return confirm('本当に削除しますか？')">
            🗑️
        </button>
    </form>
    @endsection