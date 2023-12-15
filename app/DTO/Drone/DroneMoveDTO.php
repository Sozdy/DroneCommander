<?php

namespace App\DTO\Drone;

use App\Http\Requests\Drone\DroneMoveRequest;
use App\ValueObjects\Vector2D;

class DroneMoveDTO
{
    /** @var Vector2D[] */
    public array $commands;

    public ?Vector2D $start_position;

    public ?bool $has_walls;

    public function __construct(array $commands, ?Vector2D $start_position = null, ?bool $has_walls = null)
    {
        $this->start_position = $start_position;
        $this->commands = $commands;
        $this->has_walls = $has_walls;
    }

    public static function fromRequest(DroneMoveRequest $request): DroneMoveDTO
    {
        $validated = $request->validated();

        $commands = array_map(function (string $command) {
            return Vector2D::fromAbbreviation($command);
        }, explode(',', $validated['commands']));

        $start_position = $request->start_position ?
            Vector2D::fromString($validated['start_position']) :
            null;

        $has_walls = $request->has_walls;

        return new DroneMoveDTO($commands, $start_position, $has_walls);
    }
}
