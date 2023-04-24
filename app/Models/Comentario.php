<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); //Esto es de 1 a 1 1 usuario esta ligado a 1 comentario
    }
}
