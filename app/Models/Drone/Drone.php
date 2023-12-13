<?php

namespace App\Models\Drone;

use App\Models\DroneMovement\DroneMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drone extends Model
{
    use HasFactory;

    protected $table = 'drones';

    protected $fillable = [
        'name',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(DroneMovement::class, 'drone_id', 'id');
    }
}
