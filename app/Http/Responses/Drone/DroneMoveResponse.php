<?php

namespace App\Http\Responses\Drone;

use App\ValueObjects\Vector2D;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;

class DroneMoveResponse implements Jsonable, Arrayable
{
    /**
     * @param Vector2D $final_position
     * @param Vector2D[] $optimal_way
     */
    public function __construct(
        private readonly Vector2D $final_position,
        private readonly array    $optimal_way,
    )
    {
    }

    public function toArray(): array
    {
        // TODO: Вынести сериализацию из Response
        $optimal_way = array_map(function (Vector2D $vector) {
                return $vector->toAbbreviation();
            }, $this->optimal_way);

        return [
            'final_position' => $this->final_position->toString(),
            'optimal_way' =>  implode(',',$optimal_way),
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
