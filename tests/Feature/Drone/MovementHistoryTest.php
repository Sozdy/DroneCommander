<?php

use Symfony\Component\HttpFoundation\Response;

describe('save movement history in DB', function () {
    test('in bounds', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
        ];

        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 3);
        $response->assertJsonFragment(['final_position' => '0x3']);
        $response->assertStatus(Response::HTTP_CREATED);
    });
    test('in bounds with history', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
        ];

        $this->postJson(route('drones.move'), $body_request);
        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 6);
        $response->assertJsonFragment(['final_position' => '0x6']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('in out of bounds', function () {
        $body_request = [
            'commands' => 'up,Up,UP,left',
        ];

        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 3);
        $response->assertJsonFragment(['message' => 'Position -1x3 is out of bounds']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    test('in out of bounds with history', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
        ];

        $this->postJson(route('drones.move'), $body_request);
        $this->postJson(route('drones.move'), $body_request);
        $response = $this->postJson(route('drones.move'), ['commands' => 'left']);

        $this->assertDatabaseCount('drone_movements', 6);
        $response->assertJsonFragment(['message' => 'Position -1x6 is out of bounds']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });
});

describe('save movement history in DB with walls', function () {
    test('in bounds', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
            'has_walls' => true
        ];

        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 3);
        $response->assertJsonFragment(['final_position' => '0x3']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('in bounds with history', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
        ];

        $this->postJson(route('drones.move'), $body_request);
        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 6);
        $response->assertJsonFragment(['final_position' => '0x6']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('in out of bounds', function () {
        $body_request = [
            'commands' => 'up,Up,UP,left',
            'has_walls' => true
        ];

        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 4);
        $response->assertJsonFragment(['final_position' => '1x3']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('in out of bounds with history', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
            'has_walls' => true
        ];

        $this->postJson(route('drones.move'), $body_request);
        $this->postJson(route('drones.move'), $body_request);
        $response = $this->postJson(route('drones.move'), ['commands' => 'left', 'has_walls' => true]);

        $this->assertDatabaseCount('drone_movements', 7);
        $response->assertJsonFragment(['final_position' => '1x6']);
        $response->assertStatus(Response::HTTP_CREATED);
    });
});

describe('save movement history in DB without walls', function () {
    test('in bounds', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
            'has_walls' => false
        ];

        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 3);
        $response->assertJsonFragment(['final_position' => '0x3']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('in bounds with history', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
            'has_walls' => false
        ];

        $this->postJson(route('drones.move'), $body_request);
        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 6);
        $response->assertJsonFragment(['final_position' => '0x6']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('in out of bounds', function () {
        $body_request = [
            'commands' => 'up,Up,UP,left',
            'has_walls' => false
        ];

        $response = $this->postJson(route('drones.move'), $body_request);

        $this->assertDatabaseCount('drone_movements', 3);
        $response->assertJsonFragment(['message' => 'Position -1x3 is out of bounds. Current position: 0x3']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    test('in out of bounds with history', function () {
        $body_request = [
            'commands' => 'up,Up,UP',
            'has_walls' => false
        ];

        $this->postJson(route('drones.move'), $body_request);
        $this->postJson(route('drones.move'), $body_request);
        $response = $this->postJson(route('drones.move'), ['commands' => 'left', 'has_walls' => false]);

        $this->assertDatabaseCount('drone_movements', 6);
        $response->assertJsonFragment(['message' => 'Position -1x6 is out of bounds. Current position: 0x6']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });
});
