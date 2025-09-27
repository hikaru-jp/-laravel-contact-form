<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * 複数代入可能なカラム
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel1',
        'tel2',
        'tel3',
        'address',
        'building',
        'category_id',
        'content',
    ];

    /**
     * Categoryとのリレーション
     * Contact は Category に属する（1対多の「多」側）
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

