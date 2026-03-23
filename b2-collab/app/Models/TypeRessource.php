<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeRessource extends Model
{
    use SoftDeletes;

    protected $table = 'types_ressources';
    protected $primaryKey = 'id_typeressource';
    protected $fillable = ['name_typeressource'];

    public function ressources()
    {
        return $this->hasMany(Ressources::class, 'id_typeressource', 'id_typeressource');
    }
}
