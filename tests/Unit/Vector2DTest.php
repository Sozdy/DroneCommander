<?php

//
//
//use App\ValueObjects\Vector2D;
//
//test('static method', function () {
//    $vector_zero = Vector2D::zero();
//    $vector_up = Vector2D::up();
//    $vector_down = Vector2D::down();
//    $vector_left = Vector2D::left();
//    $vector_right = Vector2D::right();
//
//    expect($vector_zero->getX())->toEqual(0);
//    expect($vector_zero->getY())->toEqual(0);
//    expect($vector_up->getX())->toEqual(0);
//    expect($vector_up->getY())->toEqual(1);
//    expect($vector_down->getX())->toEqual(0);
//    expect($vector_down->getY())->toEqual(-1);
//    expect($vector_left->getX())->toEqual(-1);
//    expect($vector_left->getY())->toEqual(0);
//    expect($vector_right->getX())->toEqual(1);
//    expect($vector_right->getY())->toEqual(0);
//});
//test('from string method', function () {
//    $array = [
//        '1x1' => [1, 1],
//        '-1x12' => [-1, 12],
//        '10000x-100000' => [10000, -100000],
//        '0x0' => [0, 0],
//        '1x2.2' => [1, 2],
//        '1.1x2.2' => [1, 2],
//        '1.9x2.2' => [1, 2],
//        '1.5x2.2' => [1, 2],
//        '1.4x2.2' => [1, 2],
//        '1.6x2.2' => [1, 2],
//    ];
//
//    foreach ($array as $string => $x_y) {
//        $vector = Vector2D::fromString($string);
//
//        expect($vector->getX())->toEqual($x_y[0]);
//        expect($vector->getY())->toEqual($x_y[1]);
//    }
//});
//
//test('from abbreviation method', function () {
//    $vector = Vector2D::fromAbbreviation('Up');
//
//    expect($vector->getX())->toEqual(0);
//    expect($vector->getY())->toEqual(1);
//});
//test('get x and get y methods', function () {
//    $vector = new Vector2D(2, 3);
//
//    expect($vector->getX())->toEqual(2);
//    expect($vector->getY())->toEqual(3);
//});
//test('add method', function () {
//    $vector1 = new Vector2D(2, 3);
//    $vector2 = new Vector2D(1, 2);
//
//    $result = $vector1->add($vector2);
//
//    expect($result->getX())->toEqual(3);
//    expect($result->getY())->toEqual(5);
//});
//test('subtract method', function () {
//    $vector1 = new Vector2D(2, 3);
//    $vector2 = new Vector2D(1, 2);
//
//    $result = $vector1->subtract($vector2);
//
//    expect($result->getX())->toEqual(1);
//    expect($result->getY())->toEqual(1);
//});
//test('equals method', function () {
//    $vector1 = new Vector2D(2, 3);
//    $vector2 = new Vector2D(2, 3);
//    $vector3 = new Vector2D(1, 1);
//
//    expect($vector1->equals($vector2))->toBeTrue();
//    expect($vector1->equals($vector3))->toBeFalse();
//});
//test('to abbreviation method', function () {
//    $vector1 = new Vector2D(2, 3);
//    $vector2 = new Vector2D(-1, 0);
//    $vector3 = new Vector2D(0, -1);
//
//    expect($vector1->toAbbreviation())->toEqual('UpRight');
//    expect($vector2->toAbbreviation())->toEqual('Left');
//    expect($vector3->toAbbreviation())->toEqual('Down');
//});
//test('to array and to json methods', function () {
//    $vector = new Vector2D(2, 3);
//
//    $array = $vector->toArray();
//    $json = $vector->toJson();
//
//    expect($array)->toEqual(['x' => 2, 'y' => 3]);
//    expect($json)->toEqual('{"x":2,"y":3}');
//});
//test('is x negative method', function () {
//    $vector1 = new Vector2D(2, 3);
//    $vector2 = new Vector2D(-2, 3);
//
//    expect($vector1->isXNegative())->toBeFalse();
//    expect($vector2->isXNegative())->toBeTrue();
//});
//test('is y negative method', function () {
//    $vector1 = new Vector2D(2, 3);
//    $vector2 = new Vector2D(2, -3);
//
//    expect($vector1->isYNegative())->toBeFalse();
//    expect($vector2->isYNegative())->toBeTrue();
//});
//test('is x greater than method', function () {
//    $vector = new Vector2D(2, 3);
//
//    expect($vector->isXGreaterThan(1))->toBeTrue();
//    expect($vector->isXGreaterThan(2))->toBeFalse();
//});
//test('is y greater than method', function () {
//    $vector = new Vector2D(2, 3);
//
//    expect($vector->isYGreaterThan(2))->toBeTrue();
//    expect($vector->isYGreaterThan(3))->toBeFalse();
//});
//test('is x less than method', function () {
//    $vector = new Vector2D(2, 3);
//
//    expect($vector->isXLessThan(3))->toBeTrue();
//    expect($vector->isXLessThan(2))->toBeFalse();
//});
//test('is y less than method', function () {
//    $vector = new Vector2D(2, 3);
//
//    expect($vector->isYLessThan(4))->toBeTrue();
//    expect($vector->isYLessThan(3))->toBeFalse();
//});
//test('to string method', function () {
//    $vector = new Vector2D(2, 3);
//
//    expect($vector->toString())->toEqual("2x3");
//});
