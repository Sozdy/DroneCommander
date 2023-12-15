<?php

namespace App\Services\Drone;

use App\Actions\Drone\DroneMoveAction;
use App\Actions\Drone\DroneMoveWithoutWallsAction;
use App\Actions\Drone\DroneMoveWithWallsAction;
use App\DTO\Drone\DroneMoveDTO;
use App\Exceptions\OutOfBoundException;
use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class DroneMovementService implements IDroneMovementService
{
    public function calculatePosition(DroneMoveDTO $drone_move_dto): Vector2D
    {
        $flight_quad = Quad::make(config('drone.flight_field.width'), config('drone.flight_field.height'));
        $start_position = $drone_move_dto->start_position ?? Vector2D::zero();
        $current_position = $start_position;

        if ($flight_quad->isOutOfBounds($start_position)) {
            throw new OutOfBoundException(
                "Start position is out of bounds. Start_position: $start_position",
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        foreach ($drone_move_dto->commands as $command) {
            $current_position = match ($drone_move_dto->has_walls) {
                true => App::make(DroneMoveWithWallsAction::class)
                    ->execute($current_position, $command, $flight_quad),
                false => App::make(DroneMoveWithoutWallsAction::class)
                    ->execute($current_position, $command, $flight_quad),
                null => App::make(DroneMoveAction::class)
                    ->execute($current_position, $command, $flight_quad),
            };
        }


        return $current_position;
    }

    public function calculateOptimalWay(?Vector2D $start_position, Vector2D $final_position): array
    {
        return [];
    }
}
