@extends('layouts.app')

@section('content')
<h2>商品登録</h2>

<form action="{{ url('/products/register') }}" method="post" enctype="multipart/form-data">
    @csrf

    <!-- 商品名 -->
    <div>
        <label>商品名</label><br>
        <input type="text" name="name" value="{{ old('name') }}">
        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
    </div>

    <!-- 値段 -->
    <div>
        <label>値段</label><br>
        <input type="number" name="price" value="{{ old('price') }}">
        <div class="form__error">
            @error('price')
            {{ $message }}
            @enderror
        </div>
    </div>

    <!-- 商品画像 -->
    <div>
        <label>商品画像</label><br>
        <input type="file" name="image">
        <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
        </div>
    </div>

    <!-- 季節 -->
    <div>
        <label>季節</label><br>
        <select name="season">
            <option value="">選択してください</option>
            @foreach($seasons as $season)
            <option value="{{ $season->id }}" {{ old('season') == $season->id ? 'selected' : '' }}>
                {{ $season->name }}
            </option>
            @endforeach
        </select>
        <div class="form__error">
            @error('season')
            {{ $message }}
            @enderror
        </div>
    </div>

    <!-- 商品説明 -->
    <div>
        <label>商品説明</label><br>
        <textarea name="description" maxlength="120">{{ old('description') }}</textarea>
        <div class="form__error">
            @error('description')
            {{ $message }}
            @enderror
        </div>
    </div>

    <br>
    <button type="submit">登録</button>
</form>

<a href="{{ url('/products') }}">← 一覧に戻る</a>
@endsection