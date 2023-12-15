<?php

namespace App\Models\DroneMovement;

use App\Casts\AsVector2D;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DroneMovement extends Model
{
    use HasFactory;

    protected $table = 'drone_movements';

    protected $casts = [
        'start_position' => AsVector2D::class,
        'command' => AsVector2D::class,
        'current_position' => AsVector2D::class,
    ];

    protected $fillable = [
        'start_position',
        'command',
        'current_position',
    ];

    public function scopeLatestRecord(Builder $query): Builder|Model
    {
        return $query->orderByDesc('created_at')
            ->orderByDesc('id');
    }
}
