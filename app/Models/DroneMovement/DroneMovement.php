<?php

namespace App\Models\DroneMovement;

use App\Casts\AsVector2D;
use App\Models\Drone\Drone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DroneMovement extends Model
{
    use HasFactory;

    protected $table = 'drone_movements';

    protected $casts = [
        'position' => AsVector2D::class,
        'command' => AsVector2D::class,
    ];

    protected $fillable = [
        'drone_id',
        'position',
        'command',
    ];

    public function drone(): BelongsTo
    {
        return $this->belongsTo(Drone::class, 'drone_id', 'id');
    }
}
