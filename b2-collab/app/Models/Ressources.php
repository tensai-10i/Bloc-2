<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressources extends Model
{
    use HasFactory;

    protected $table = 'resources';
    protected $primaryKey = 'id_ressource';
    protected $fillable = ['name_ressource', 'description', 'type_id', 'category_id'];

    public function typeRessource()
    {
        return $this->belongsTo(TypeRessource::class, 'type_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'resource_id', 'id_ressource')->latest();
    }
}
