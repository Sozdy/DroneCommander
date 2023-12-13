<?php

namespace App\Services\Drone;

use App\DTO\Drone\DroneMoveDTO;
use App\ValueObjects\Vector2D;

interface IDroneService
{
    public function calculatePosition(DroneMoveDTO $drone_move_dto): Vector2D;

    /**
     * @param ?Vector2D $start_position
     * @param Vector2D $final_position
     * @return Vector2D[]
     */
    public function calculateOptimalWay(?Vector2D $start_position, Vector2D $final_position): array;
}
