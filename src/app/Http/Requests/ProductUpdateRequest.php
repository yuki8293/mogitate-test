<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',                // 商品名：入力必須
            'price' => 'required|integer|min:0|max:10000',      // 値段：入力必須、数値、0~10000円以内
            'image' => 'required|image|mimes:jpeg,png|max:2048', // 商品画像：必須、.png または .jpeg
            'seasons' => 'required|array',                      // 季節：選択必須（複数チェック可）
            'seasons.*' => 'integer|exists:seasons,id',         // 配列の中身は整数で有効ID
            'description' => 'required|string|max:120',        // 商品説明：入力必須、最大120文字
        ];
    }

    /**
     * 日本語エラーメッセージ
     */
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',

            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0〜10000円以内で入力してください',
            'price.max' => '0〜10000円以内で入力してください',

            'image.required' => '画像を登録してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',

            'seasons.required' => '季節を選択してください',
            'seasons.*.integer' => '季節が無効です',
            'seasons.*.exists' => '季節が無効です',

            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }
}
