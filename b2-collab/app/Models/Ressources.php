<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressources extends Model
{
    use HasFactory;

    protected $table = 'resources';
    protected $primaryKey = 'id_ressource';

    protected $fillable = [
        'name_ressource',
    ];
    public $timestamps = true;
}
