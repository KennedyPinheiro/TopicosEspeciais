<?php
// app/Models/ClienteDetalhe.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDetalhe extends Model
{
    use HasFactory;

    protected $table = 'cliente_detalhes';

    protected $fillable = [
        'user_role_id',
        'limite_credito',
        'categoria',
        'data_adesao',
        'observacoes',
    ];

    protected $casts = [
        'limite_credito' => 'decimal:2',
        'data_adesao' => 'date',
    ];

    // Relações
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            UserRole::class,
            'id',
            'id',
            'user_role_id',
            'user_id'
        );
    }
}