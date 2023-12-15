<?php

namespace App\Actions\Drone;

use App\Exceptions\OutOfBoundException;
use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;
use Symfony\Component\HttpFoundation\Response;

class DroneMoveAction
{
    public function execute(Vector2D $start_position, Vector2D $command, Quad $flight_quad): Vector2D
    {
        $current_position = $start_position->add($command);

        if ($flight_quad->isOutOfBounds($current_position)) {
            throw new OutOfBoundException(
                "Position $current_position is out of bounds",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $current_position;
    }
}
