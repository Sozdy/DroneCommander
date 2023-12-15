<?php

namespace App\Actions\Drone;

use App\DTO\Drone\DroneMoveDTO;
use App\Exceptions\OutOfBoundException;
use App\Models\DroneMovement\DroneMovement;
use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;
use Symfony\Component\HttpFoundation\Response;

class GetStartPositionDroneAction
{
    public function execute(DroneMoveDTO $drone_move_dto): Vector2D
    {
        return $drone_move_dto->start_position ??
            DroneMovement::latestRecord()->first()?->current_position ??
            Vector2D::zero();



    }
}
