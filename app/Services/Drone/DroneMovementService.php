<?php

namespace App\Services\Drone;

use App\Actions\Drone\ConvertPathToCommandsDroneAction;
use App\Actions\Drone\GetOptimalPathDroneAction;
use App\Actions\Drone\MoveDroneAction;
use App\Actions\Drone\MoveDroneWithoutWallsAction;
use App\Actions\Drone\MoveDroneWithWallsAction;
use App\DTO\Drone\DroneMoveDTO;
use App\Exceptions\OutOfBoundException;
use App\Models\DroneMovement\DroneMovement;
use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class DroneMovementService implements IDroneMovementService
{
    public function calculatePosition(DroneMoveDTO $drone_move_dto): Vector2D
    {
        $flight_quad = Quad::make(config('drone.flight_field.width'), config('drone.flight_field.height'));

        $start_position = $drone_move_dto->start_position ??
            DroneMovement::query()->latestRecord()->first()?->current_position ??
            Vector2D::zero();
        $current_position = $start_position;

        if ($flight_quad->isOutOfBounds($start_position)) {
            throw new OutOfBoundException(
                "Start position is out of bounds. Start_position: $start_position",
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        foreach ($drone_move_dto->commands as $command) {
            $current_position = match ($drone_move_dto->has_walls) {
                true => App::make(MoveDroneWithWallsAction::class)
                    ->execute($current_position, $command, $flight_quad),
                false => App::make(MoveDroneWithoutWallsAction::class)
                    ->execute($current_position, $command, $flight_quad),
                null => App::make(MoveDroneAction::class)
                    ->execute($current_position, $command, $flight_quad),
            };
        }

        return $current_position;
    }

    public function calculateOptimalCommands(?Vector2D $start_position, Vector2D $final_position): array
    {
        $flight_quad = Quad::make(config('drone.flight_field.width'), config('drone.flight_field.height'));
        if ($flight_quad->isOutOfBounds($start_position)) {
            throw new OutOfBoundException(
                "Start position is out of bounds. Start_position: $start_position",
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $path = App::make(GetOptimalPathDroneAction::class)
            ->execute($start_position, $final_position, $flight_quad);

        return App::make(ConvertPathToCommandsDroneAction::class)->execute($path);
    }
}
