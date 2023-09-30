<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'image_path',
    ];

    // Mağazaya ait banner'ı temsil eden ilişkiyi tanımlayın
    public function store()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
