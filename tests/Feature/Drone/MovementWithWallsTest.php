<?php

use Symfony\Component\HttpFoundation\Response;

describe('movement test', function () {
    test('case 1', function () {
        $data = [
            'body_request' => [
                'commands' => 'left',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '1x0',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 2', function () {
        $data = [
            'body_request' => [
                'commands' => 'up,left',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '1x1',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 3', function () {
        $data = [
            'body_request' => [
                'commands' => 'down',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '0x1',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 4', function () {
        $data = [
            'body_request' => [
                'commands' => 'up',
                'start_position' => '99x99',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '99x98',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);
    });

    test('case 5', function () {
        $data = [
            'body_request' => [
                'commands' => 'right',
                'start_position' => '99x99',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '98x99',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);
    });
});

describe('get right position', function () {
    test('case 1: move up', function () {
        $data = [
            'body_request' => [
                'commands' => 'up,Up,UP',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '0x3',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);

        $this->refreshDatabase();
    });

    test('case 2: move right', function () {
        $data = [
            'body_request' => [
                'commands' => 'Right,RIGHT,right',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '3x0',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);

        $this->refreshDatabase();
    });

    test('case 3: move through multiple directions', function () {
        $data = [
            'body_request' => [
                'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '3x0',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);

        $this->refreshDatabase();
    });

    test('case 4: move through all directions from start_position 50x50', function () {
        $data = [
            'body_request' => [
                'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN,Left,LEFT,left',
                'start_position' => '50x50',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '50x50',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);

        $this->refreshDatabase();
    });

    test('case 5: move up and right from start_position 50x50', function () {
        $data = [
            'body_request' => [
                'commands' => 'up,Up,UP,Right,RIGHT,right',
                'start_position' => '50x50',
                'has_walls' => true,
            ],
            'assert_response' => [
                'final_position' => '53x53',
            ],
        ];

        $response = $this->postJson(route('drones.move'), $data['body_request']);

        $response->assertJsonFragment($data['assert_response']);
        $response->assertStatus(Response::HTTP_CREATED);

        $this->refreshDatabase();
    });
});
