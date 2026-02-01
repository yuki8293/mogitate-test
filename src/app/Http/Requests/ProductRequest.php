<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',                // 商品名 必須
            'price' => 'required|integer|min:0|max:10000',      // 値段 必須、整数、0~10000
            'image' => 'required|image|mimes:jpeg,png|max:2048', // 商品画像 必須、jpegかpng
            'season' => 'required|exists:seasons,id',           // 季節 必須、存在するID
            'description' => 'required|string|max:120',        // 商品説明 必須、120文字以内
        ];
    }

    /**
     * エラーメッセージを日本語でカスタマイズ
     */
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',

            // 値段
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0〜10000円以内で入力してください',
            'price.max' => '0〜10000円以内で入力してください',

            // 画像
            'image.required' => '画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.image' => '画像ファイルを選択してください',

            // 季節
            'season.required' => '季節を選択してください',
            'season.exists' => '季節が無効です',

            // 商品説明
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }
}
