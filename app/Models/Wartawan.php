<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wartawan extends Model
{
    use HasFactory;

    protected $table = 'wartawan';
    protected $fillable = ['nama', 'email'];

    public function news()
    {
        return $this->hasMany(News::class, 'wartawan_id');
    }
}
