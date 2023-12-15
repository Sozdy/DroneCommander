<?php

use App\ValueObjects\Quad;
use App\ValueObjects\Vector2D;

describe('position is out of bounds', function () {
    test('position is out of bounds by x', function () {
        $quad = Quad::make(5, 5);

        $position = new Vector2D(6, 0);

        expect($quad->isOutOfBounds($position))->toBeTrue();
    });
    test('position is out of bounds by y', function () {
        $quad = Quad::make(5, 5);

        $position = new Vector2D(0, 6);

        expect($quad->isOutOfBounds($position))->toBeTrue();
    });
    test('position is out of bounds by x and y', function () {
        $quad = Quad::make(5, 5);

        $position = new Vector2D(6, 6);

        expect($quad->isOutOfBounds($position))->toBeTrue();
    });
    test('position is out of bounds by x and y negative', function () {
        $quad = Quad::make(5, 5);

        $position = new Vector2D(-1, -1);

        expect($quad->isOutOfBounds($position))->toBeTrue();
    });
});

test('position is not out of bounds', function () {
    $quad = Quad::make(5, 5);

    $position = Vector2D::zero();

    expect($quad->isOutOfBounds($position))->toBeFalse();
});
