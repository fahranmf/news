<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $table = 'komentar';

    protected $fillable = ['nama', 'isi', 'news_id'];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
