<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios'; 
    protected $primaryKey = 'idusuario'; 
    protected $hidden = ['password']; 
    public $timestamps = false; 
    
    protected $fillable =[
        'nombre', 'email', 'password', 'foto',
    ];
    public function juegos(){
        return $this->belongsToMany(Juego::class, 'juego_usuario', 'idusuario', 'idjuego')
        ->withPivot('privado')
        ->withTimestamps();
    }

    public function agregarJuego(Juego $juego, $privado=true){
        $this->juegos()->attach($juego, ['privado'=>$privado]);
    }
}
