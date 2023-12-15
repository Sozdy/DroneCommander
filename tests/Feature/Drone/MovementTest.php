<?php

use Symfony\Component\HttpFoundation\Response;

describe('movement test', function () {
    test('out of bounds', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => 'left',
                ],
                'expected_message' => 'Position -1x0 is out of bounds'
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => 'up,left',
                ],
                'expected_message' => 'Position -1x1 is out of bounds'
            ],
            'case_3' => [
                'body_request' => [
                    'commands' => 'down',
                ],
                'expected_message' => 'Position 0x-1 is out of bounds'
            ],
            'case_4' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => '99x99'
                ],
                'expected_message' => 'Position 99x100 is out of bounds'
            ],
            'case_5' => [
                'body_request' => [
                    'commands' => 'right',
                    'start_position' => '99x99'
                ],
                'expected_message' => 'Position 100x99 is out of bounds'
            ],
        ];

        foreach ($data as $case) {
            $response = $this->postJson(route('drones.move'), $case['body_request']);

            $response->assertJsonFragment(['message' => $case['expected_message']]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    });


    test('get right position', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => 'up,Up,UP',
                ],
                'assert_response' => [
                    'final_position' => '0x3'
                ],
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => 'Right,RIGHT,right',
                ],
                'assert_response' => [
                    'final_position' => '3x0'
                ],
            ],
            'case_3' => [
                'body_request' => [
                    'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN',
                ],
                'assert_response' => [
                    'final_position' => '3x0'
                ],
            ],
            'case_4' => [
                'body_request' => [
                    'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN,Left,LEFT,left',
                    'start_position' => '50x50'
                ],
                'assert_response' => [
                    'final_position' => '50x50'
                ],
            ],
            'case_5' => [
                'body_request' => [
                    'commands' => 'up,Up,UP,Right,RIGHT,right',
                    'start_position' => '50x50'
                ],
                'assert_response' => [
                    'final_position' => '53x53'
                ],
            ],
        ];

        foreach ($data as $case) {
            $response = $this->postJson(route('drones.move'), $case['body_request']);

            $response->assertJsonFragment($case['assert_response']);
            $response->assertStatus(Response::HTTP_CREATED);
        }
    });
});
