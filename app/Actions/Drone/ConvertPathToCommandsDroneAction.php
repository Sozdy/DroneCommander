<?php

namespace App\Actions\Drone;

use App\ValueObjects\Vector2D;

class ConvertPathToCommandsDroneAction
{
    /**
     * @param  Vector2D[]  $path
     * @return Vector2D[]
     */
    public function execute(array $path): array
    {
        $commands = [];
        for ($i = 1; $i < count($path); $i++) {
            $commands[$i - 1] = $path[$i]->subtract($path[$i - 1]);
        }

        return $commands;
    }
}
