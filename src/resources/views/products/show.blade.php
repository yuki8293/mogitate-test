@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')

<div class="product-detail-container">
    <h2>商品詳細</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div>
            <p class="breadcrumb">
                <a href="{{ url('/products') }}">商品一覧</a> > {{ $product->name }}<br>
            </p>

            <div class="product-detail-main">

                <!-- 左：画像 -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="150"><br>


                <input type="file" name="image" class="input-file">

                <div class="form__error">
                    @error('image')
                    <div>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 右：情報 -->
            <div class="product-detail-info">
                {{-- 商品名 --}}

                <div class="form-group">
                    <label>商品名</label><br>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="input-field">

                    <div class="form__error">
                        @error('name')
                        <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 価格 --}}
                <div class="form-group">
                    <label>値段</label><br>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}">

                    <div class="form__error">
                        @error('price')
                        <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 季節 --}}
                <div class="form-group seasons-group">
                    <label>季節</label><br>

                    @php
                    $allSeasons = ['春' => 1, '夏' => 2, '秋' => 3, '冬' => 4];
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
                        <div>{{ $message }}</div>
                        @enderror
                        @error('seasons.*')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- 商品説明 --}}
                <div class="form-group">
                    <label>商品説明</label><br>
                    <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>

                    <div class="form__error">
                        @error('description')
                        <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="action-buttons">
                    <button type="button" onclick="location.href='{{ url('/products') }}'">戻る</button>

                    <button type="submit" class="product-detail-save">変更を保存</button>

    </form>

    {{-- 削除 --}}
    <form action="{{ url('/products/' . $product->id . '/delete') }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" onclick="return confirm('本当に削除しますか？')">
            🗑️
        </button>
    </form>
</div>
@endsection