<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Accessor para URL completa da foto
    public function getPictureAttribute($value)
    {
        return $value ? url('src/imagens/' . $value) : url('src/imagens/avatar-placeholder.png');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
