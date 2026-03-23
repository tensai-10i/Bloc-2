<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'category';
    protected $primaryKey = 'id_cat';

    protected $fillable = [
        'name_cat'
    ];

    /**
     * Get the resources in this category.
     */
    public function ressources()
    {
        return $this->hasMany(Ressources::class, 'id_cat', 'id_cat');
    }
}
