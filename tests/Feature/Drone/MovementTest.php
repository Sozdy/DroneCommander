<?php

use Symfony\Component\HttpFoundation\Response;

describe('movement test out of bounds', function () {
    test('case 1', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'left',
        ]);

        $response->assertJsonFragment([
            'message' => 'Position -1x0 is out of bounds',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    test('case 2', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'up,left',
        ]);

        $response->assertJsonFragment([
            'message' => 'Position -1x1 is out of bounds',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    test('case 3', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'down',
        ]);

        $response->assertJsonFragment([
            'message' => 'Position 0x-1 is out of bounds',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    test('case 4', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'up',
            'start_position' => '99x99',
        ]);

        $response->assertJsonFragment([
            'message' => 'Position 99x100 is out of bounds',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    test('case 5', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'right',
            'start_position' => '99x99',
        ]);

        $response->assertJsonFragment([
            'message' => 'Position 100x99 is out of bounds',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });
});

describe('get right position', function () {
    test('case 1', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'up,Up,UP',
        ]);

        $response->assertJsonFragment([
            'final_position' => '0x3',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 2', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'Right,RIGHT,right',
        ]);

        $response->assertJsonFragment([
            'final_position' => '3x0',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 3', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN',
        ]);

        $response->assertJsonFragment([
            'final_position' => '3x0',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 4', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN,Left,LEFT,left',
            'start_position' => '50x50',
        ]);

        $response->assertJsonFragment([
            'final_position' => '50x50',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 5', function () {
        $response = $this->postJson(route('drones.move'), [
            'commands' => 'up,Up,UP,Right,RIGHT,right',
            'start_position' => '50x50',
        ]);

        $response->assertJsonFragment([
            'final_position' => '53x53',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    });
});
