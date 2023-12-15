<?php

namespace App\Http\Responses\Drone;

use App\ValueObjects\Vector2D;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class DroneMoveResponse implements Arrayable, Jsonable
{
    /**
     * @param  Vector2D[]  $optimal_way
     */
    public function __construct(
        private readonly Vector2D $final_position,
        private readonly array $optimal_way,
    ) {
    }

    public function toArray(): array
    {
        $final_position = $this->final_position
            ->toString();

        $optimal_way = collect($this->optimal_way)
            ->map(fn(Vector2D $position) => $position->toAbbreviation())
            ->implode(',');

        return [
            'final_position' => $final_position,
            'optimal_way' => $optimal_way,
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
