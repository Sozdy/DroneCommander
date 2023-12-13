<?php

namespace App\Services\Drone;

use App\DTO\Drone\DroneMoveDTO;
use App\ValueObjects\Vector2D;

class DroneService implements IDroneService
{
    public function calculatePosition(DroneMoveDTO $drone_move_dto): Vector2D
    {
        return Vector2D::$zero;
    }

    public function calculateOptimalWay(?Vector2D $start_position, Vector2D $final_position): array
    {
        return [Vector2D::$zero];
    }
}
