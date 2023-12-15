<?php

namespace App\ValueObjects;

class Quad
{
    private Vector2D $left_bottom;

    private Vector2D $right_bottom;

    private Vector2D $left_top;

    private Vector2D $right_top;

    public function __construct(Vector2D $left_bottom, Vector2D $right_bottom, Vector2D $left_top, Vector2D $right_top)
    {
        $this->left_bottom = $left_bottom;
        $this->right_bottom = $right_bottom;
        $this->left_top = $left_top;
        $this->right_top = $right_top;
    }

    public static function make(int $width, int $height): Quad
    {
        $x_cells_count = $width - 1;
        $y_cells_count = $height - 1;

        return new static(
            Vector2D::zero(),
            new Vector2D($x_cells_count, 0),
            new Vector2D(0, $y_cells_count),
            new Vector2D($x_cells_count, $y_cells_count)
        );
    }

    public function getLeftBottom(): Vector2D
    {
        return $this->left_bottom;
    }

    public function getRightBottom(): Vector2D
    {
        return $this->right_bottom;
    }

    public function getLeftTop(): Vector2D
    {
        return $this->left_top;
    }

    public function getRightTop(): Vector2D
    {
        return $this->right_top;
    }

    public function isOutOfBounds(Vector2D $vector2D): bool
    {
        return $vector2D->getX() < $this->getLeftBottom()->getX()
            || $vector2D->getY() < $this->getLeftBottom()->getY()
            || $vector2D->getX() > $this->getRightTop()->getX()
            || $vector2D->getY() > $this->getRightTop()->getY();
    }
}
