<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['ressource_id', 'user_id', 'content'];

    public function ressource()
    {
        return $this->belongsTo(Ressource::class, 'ressource_id', 'id_ressource');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
