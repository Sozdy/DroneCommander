<?php

namespace App\Http\Controllers\Drone;

use App\DTO\Drone\DroneMoveDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drone\DroneMoveRequest;
use App\Http\Responses\Drone\DroneMoveResponse;
use App\Services\Drone\IDroneMovementService;
use App\ValueObjects\Vector2D;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class DroneController extends Controller
{
    public function __construct(
        private readonly IDroneMovementService $droneService,
    ) {
    }

    public function move(DroneMoveRequest $request)
    {
        $drone_move_dto = DroneMoveDTO::fromRequest($request);
        $final_position = $this->droneService
            ->calculatePosition($drone_move_dto);

        $optimal_way_commands = $this->droneService
            ->calculateOptimalCommands($drone_move_dto->start_position ?? Vector2D::zero(), $final_position);

        return response(
            App::make(
                DroneMoveResponse::class,
                [
                    'final_position' => $final_position,
                    'optimal_way' => $optimal_way_commands,
                ]
            ),
            Response::HTTP_CREATED
        );
    }
}
