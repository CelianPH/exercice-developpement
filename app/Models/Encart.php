<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encart extends Model
{
    use HasFactory;

    protected $fillable = [
        'Référence',
        'image_bannière',
        'date_debut',
        'date_fin',
        'tags',
    ];
}