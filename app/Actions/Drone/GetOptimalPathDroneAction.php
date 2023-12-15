<?php

namespace App\Actions\Drone;

use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;

class GetOptimalPathDroneAction
{
    /**
     * @return Vector2D[]
     */
    public function execute(Vector2D $start_position, Vector2D $final_position, Quad $flight_quad): array
    {
        $queue = collect([$start_position]);
        $visited = $this->initializeVisitedArray($start_position);
        $parent = $this->initializeParentArray($start_position);

        $is_found = false;
        $target = null;

        while (! $queue->isEmpty()) {
            $current = $queue->shift();

            if ($final_position->equals($current)) {
                $is_found = true;
                $target = $current;
                break;
            }

            $neighbors = $this->generateNeighbors($current);

            foreach ($neighbors as $neighbor) {
                if ($flight_quad->isOutOfBounds($neighbor)) {
                    continue;
                }

                if ($this->isVisited($visited, $neighbor)) {
                    continue;
                }

                $visited = $this->markVisited($visited, $neighbor);
                $parent = $this->setParent($parent, $neighbor, $current);
                $queue->push($neighbor);
            }
        }

        if (! $is_found) {
            return [];
        }

        return $this->calculatePath($parent, $start_position, $target);
    }

    private function initializeVisitedArray(Vector2D $start_position): array
    {
        $visited = [];
        $visited[$start_position->getX()][$start_position->getY()] = true;

        return $visited;
    }

    private function initializeParentArray(Vector2D $start_position): array
    {
        $parent = [];
        $parent[$start_position->getX()][$start_position->getY()] = null;

        return $parent;
    }

    private function generateNeighbors(Vector2D $position): array
    {
        return [
            $position->add(Vector2D::left()),
            $position->add(Vector2D::right()),
            $position->add(Vector2D::down()),
            $position->add(Vector2D::up()),
        ];
    }

    private function isVisited(array $visited, Vector2D $position): bool
    {
        return isset($visited[$position->getX()][$position->getY()]);
    }

    private function markVisited(array $visited, Vector2D $position): array
    {
        $visited[$position->getX()][$position->getY()] = true;

        return $visited;
    }

    private function setParent(array $parent, Vector2D $position, Vector2D $parent_position): array
    {
        $parent[$position->getX()][$position->getY()] = $parent_position;

        return $parent;
    }

    private function calculatePath(array $parent, Vector2D $start_position, Vector2D $target): array
    {
        $path = [];
        $current = $target;
        while ($current != $start_position) {
            $path[] = $current;
            $current = $parent[$current->getX()][$current->getY()];
        }
        $path[] = $start_position;

        return array_reverse($path);
    }
}
