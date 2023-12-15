<?php


use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;

test('position is out of bounds', function () {
    $quad = Quad::make(5, 5);

    $position = $quad->getRightTop()->add(new Vector2D (1, 1));

    expect($quad->isOutOfBounds($position))->toBeTrue();
});

test('position is not out of bounds', function () {
    $quad = Quad::make(5, 5);

    $position = $quad->getRightTop()->add(Vector2D::zero());

    expect($quad->isOutOfBounds($position))->toBeFalse();
});

