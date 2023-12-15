<?php

namespace App\Actions\Drone;

use App\Exceptions\OutOfBoundException;
use App\Models\DroneMovement\DroneMovement;
use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;
use Symfony\Component\HttpFoundation\Response;

class MoveDroneWithWallsAction
{
    public function execute(Vector2D $start_position, Vector2D $command, Quad $flight_quad): Vector2D
    {
        $current_position = $start_position->add($command);

        if ($flight_quad->isOutOfBounds($current_position)) {
            $current_position = $start_position->subtract($command);
        }

        DroneMovement::create([
            'start_position' => $start_position,
            'command' => $command,
            'current_position' => $current_position,
        ]);

        return $current_position;
    }
}
