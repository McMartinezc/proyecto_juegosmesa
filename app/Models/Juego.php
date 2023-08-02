<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;
    protected $table = 'juegos';
    protected $primaryKey = 'idjuego';
    public $timestamps = false;

    protected $fillable =[
        'nombre', 'descripcion', 'n_jugadores', 'tematica', 'tiempo_juego', 'imagen',
    ];

    
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'juego_usuario', 'idjuego', 'idusuario')
                    ->withPivot('privado');
    }

    public static function consulta($filtro){
        if($filtro){
            //Utilizamos like para buscar juegos que coincidan
            return Juego::where('nombre', 'like', '%'.$filtro.'%')->get();
        }else{
            return Juego::all();
        } 
     }
}
