<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeRessource extends Model
{
    protected $table = 'types_ressources';
    protected $primaryKey = 'id_typeressource';

    protected $fillable = [
        'name_typeressource',
    ];

    public function ressources()
    {
        return $this->hasMany(Ressources::class, 'id_typeressource');
    }
}
