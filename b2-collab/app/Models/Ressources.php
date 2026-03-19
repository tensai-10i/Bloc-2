<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ressources extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resources';
    protected $primaryKey = 'id_ressource';

    protected $fillable = [
        'name_ressource',
        'description',
        'nb_visites',
        'derniere_connexion',
        'id_typeressource',
        'id_cat',
        'user_id',
    ];

    protected $casts = [
        'derniere_connexion' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Get the category that this resource belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_cat', 'id_cat');
    }

    /**
     * Get the type that this resource belongs to.
     */
    public function type()
    {
        return $this->belongsTo(TypeRessource::class, 'id_typeressource', 'id_typeressource');
    }

    /**
     * Get the user who created this resource.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
