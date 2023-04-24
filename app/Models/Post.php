<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']); //Esta relacion es que una publicacion esta hecha por un usuario
    }

    public function comentarios() //Este es para que un post tenga multipples comentarios
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //METODO PARA QUE REVISE SI UN USUARIO YA LE DIO LIKE A UNA PUBLICACION
    public function checkLike(User $user)
    {
        /* Esto lo que hace es que va a validar gracias a la relacion de likes se situa directamente en la tabla y al pasarle el user id le decimos que revise si ese
        user id ya esta */
        return $this->likes->contains('user_id', $user->id);
    }
}
