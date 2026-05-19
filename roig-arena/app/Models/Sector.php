<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $table = 'sectores';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'asientos_total',
        'precio_base',
        'activo',
    ];

    /**
     * Casteo de tipos
     */
    protected $casts = [
        'activo' => 'boolean',
        'asientos_total' => 'integer',
        'precio_base' => 'decimal:2',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Un sector tiene muchos asientos
     */
    public function asientos()
    {
        return $this->hasMany(Asiento::class);
    }

    /**
     * Un sector tiene muchos precios (uno por evento)
     */
    public function precios()
    {
        return $this->hasMany(Precio::class);
    }

    /**
     * Un sector está disponible en muchos eventos (a través de precios)
     */
    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'precios')
                    ->withPivot('precio', 'disponible')
                    ->withTimestamps();
    }

    // ============================================
    // MÉTODOS ÚTILES
    // ============================================

    /**
     * Verificar si el sector está activo globalmente
     */
    public function estaActivo(): bool
    {
        return $this->activo;
    }

    /**
     * Obtener el número total de asientos del sector
     */
    public function totalAsientos(): int
    {
        return $this->asientos()->count();
    }

    /**
     * Precio base efectivo del sector.
     */
    public function precioBaseEfectivo(): float
    {
        if ($this->precio_base !== null) {
            return (float) $this->precio_base;
        }

        return match (true) {
            str_starts_with($this->nombre, 'Palco') => 150.00,
            $this->nombre === 'FRONT STAGE' => 120.00,
            $this->nombre === 'CLUB' => 100.00,
            $this->nombre === 'JOHNNIE WALKER' => 90.00,
            $this->nombre === 'PISTA' => 80.00,
            str_starts_with($this->nombre, 'Sector 10') => 50.00,
            str_starts_with($this->nombre, 'Sector 30') => 40.00,
            default => 50.00,
        };
    }

    /**
     * Capacidad efectiva del sector.
     */
    public function capacidadEfectiva(): int
    {
        return (int) ($this->asientos_total ?: $this->totalAsientos());
    }

    /**
     * Obtener asientos disponibles para un evento específico
     */
    public function asientosDisponiblesParaEvento($eventoId)
    {
        return $this->asientos()
            ->whereDoesntHave('estadoAsientos', function ($query) use ($eventoId) {
                $query->where('evento_id', $eventoId);
            })
            ->get();
    }

    /**
     * Scope: Solo sectores activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}