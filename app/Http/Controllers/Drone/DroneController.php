<?php

namespace App\Http\Controllers\Drone;

use App\DTO\Drone\DroneMoveDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drone\DroneMoveRequest;
use App\Http\Responses\Drone\DroneMoveResponse;
use App\Services\Drone\IDroneService;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class DroneController extends Controller
{
    public function __construct(
        private readonly IDroneService $droneService,
    )
    {
    }

    public function move(DroneMoveRequest $request)
    {
        $drone_move_dto = DroneMoveDTO::fromRequest($request);

        $final_position = $this
            ->droneService
            ->calculatePosition($drone_move_dto);

        $optimal_way = $this
            ->droneService
            ->calculateOptimalWay($drone_move_dto->start_position, $final_position);

        return response(
            App::make(DroneMoveResponse::class, [$final_position, $optimal_way]),
            Response::HTTP_CREATED
        );
    }
}
