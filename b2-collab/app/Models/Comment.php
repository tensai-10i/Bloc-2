<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ressources;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_comment';
    protected $fillable = ['content', 'user_id', 'resource_id'];

    public function ressource()
    {
        return $this->belongsTo(Ressources::class, 'resource_id', 'id_ressource');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
