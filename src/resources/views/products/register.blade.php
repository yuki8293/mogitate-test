@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h2>商品登録</h2>

    <form action="{{ url('/products/register') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
        <div class="form-group">
            <label class="form-label">
                商品名
                <span class="required">必須</span>
            </label><br>

            <input type="text" name="name" value="{{ old('name') }}">
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>

        <!-- 値段 -->
        <div class="form-group">
            <label class="form-label">
                値段
                <span class="required">必須</span>
            </label><br>

            <input type="number" name="price" value="{{ old('price') }}">
            <div class="form__error">
                @error('price')
                {{ $message }}
                @enderror
            </div>
        </div>

        {{-- 商品画像 --}}
        <div class="form-group">
            <label class="form-label">
                商品画像
                <span class="required">必須</span>
            </label><br>

            <input type="file" name="image" id="imageInput" accept="image/*"><br>

            {{-- 画像プレビュー --}}
            <img id="preview" src="" alt="選択した画像" style="max-width:150px; margin-top:10px; display:none;">

            <div class="form__error">
                @error('image')
                {{ $message }}
                @enderror
            </div>
        </div>
        <script>
            const imageInput = document.getElementById('imageInput');
            const preview = document.getElementById('preview');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.setAttribute('src', e.target.result);
                        preview.style.display = 'block'; // 画像を表示
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.setAttribute('src', '');
                    preview.style.display = 'none'; // ファイルなしなら非表示
                }
            });
        </script>

        <!-- 季節 -->
        <div class="form-group">
            <label class="form-label">
                季節
                <span class="required">必須</span>
            </label><br>
            <span class="note">※複数選択可</span>

            <div class="season-options">
                @php
                $allSeasons = ['春' => 1, '夏' => 2, '秋' => 3, '冬' => 4];
                $selectedSeasons = old('season', []);
                @endphp

                @foreach($allSeasons as $name => $id)
                <label style="cursor:pointer; user-select:none;">
                    <input type="checkbox" name="season[]" value="{{ $id }}"
                        @if(in_array($id, $selectedSeasons)) checked @endif>
                    {{ $name }}
                </label>
                @endforeach

                <div class="form__error">
                    @error('season')
                    {{ $message }}
                    @enderror
                    @error('season.*')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <!-- 商品説明 -->
        <div class="form-group">
            <label class="form-label">
                商品説明
                <span class="required">必須</span>
            </label><br>

            <textarea name="description" maxlength="120">{{ old('description') }}</textarea>
            <div class="form__error">
                @error('description')
                {{ $message }}
                @enderror
            </div>
        </div>

        <br>
        <div class="form-actions">
            <button type="submit" class="btn-submit">登録</button>

            <a href="{{ url('/products') }}" class="btn-submit">戻る</a>
        </div>
    </form>
    @endsection