<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 登録・更新可能なカラムを指定
    protected $fillable = ['name', 'price', 'image', 'description'];

    // 季節とのリレーション
    public function seasons()
    {
        return $this->belongsToMany(
            Season::class,        // 関連モデル
            'product_season',     // 中間テーブル
            'product_id',         // このモデル側の外部キー
            'season_id'           // 関連モデル側の外部キー
        )->withTimestamps();
    }
}
