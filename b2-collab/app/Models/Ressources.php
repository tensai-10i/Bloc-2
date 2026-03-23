<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Comment;
use App\Models\TypeRessource;
use App\Models\User;

class Ressources extends Model
{
    use HasFactory;

    protected $table = 'resources';
    protected $primaryKey = 'id_ressource';
    protected $fillable = ['name_ressource', 'description', 'type_id', 'category_id', 'user_id'];

    public function typeRessource()
    {
        return $this->belongsTo(TypeRessource::class, 'type_id', 'id_typeressource');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_cat');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'resource_id', 'id_ressource')->latest();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
