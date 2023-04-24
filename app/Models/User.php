<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //Los datos que se espera que el usuario nos de
    protected $fillable = [
        'name',
        'email',
        'password',
        //Lo tenemos que decir que tambien esperamos el valor de username
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //la relacion es solo de los modelos
    //Creando la relacion
    public function posts()
    {
        return $this->hasMany(Post::class); //Esta es la inversa de post es decir un usuario le pertenece muchos posts
    }

    public function likes()
    {
        //Usamos hasmany ya que puede tener multiple likes
        return $this->hasMany(Like::class);
    }

    //Crear metodo para almacenar los seguidores de un usuario
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); //Esto es para muchos //Al momento de crear la relacion le decimos que este caso va a ser para el campo followers
    }

    //Crear el metodo para ver los que seguimos
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id'); //Esto es para muchos //Al momento de crear la relacion le decimos que este caso va a ser para el campo followers
    }

    //Metodo para comprobar si ya lo esta siguiendo
    public function siguiendo(User $user)
    {
        return $this->followers->contains($user->id); //Con esto se compruba y nos devuelve true o false
    }

}
