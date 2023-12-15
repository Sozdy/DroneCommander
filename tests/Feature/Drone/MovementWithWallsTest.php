<?php

use Symfony\Component\HttpFoundation\Response;

describe('movement test', function () {
    test('out of bounds', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => 'left',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '1x0',
                ],
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => 'up,left',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '1x1',
                ],
            ],
            'case_3' => [
                'body_request' => [
                    'commands' => 'down',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '0x1',
                ],
            ],
            'case_4' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => '99x99',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '99x98',
                ],
            ],
            'case_5' => [
                'body_request' => [
                    'commands' => 'right',
                    'start_position' => '99x99',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '98x99',
                ],
            ],
        ];

        foreach ($data as $case) {
            $response = $this->postJson(route('drones.move'), $case['body_request']);

            $response->assertJsonFragment($case['assert_response']);
            $response->assertStatus(Response::HTTP_CREATED);
        }
    });


    test('get right position', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => 'up,Up,UP',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '0x3'
                ],
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => 'Right,RIGHT,right',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '3x0',
                ],
            ],
            'case_3' => [
                'body_request' => [
                    'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '3x0',
                ],
            ],
            'case_4' => [
                'body_request' => [
                    'commands' => 'up,Up,UP,Right,RIGHT,right,down,Down,DOWN,Left,LEFT,left',
                    'start_position' => '50x50',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '50x50',
                ],
            ],
            'case_5' => [
                'body_request' => [
                    'commands' => 'up,Up,UP,Right,RIGHT,right',
                    'start_position' => '50x50',
                    'has_walls' => true,
                ],
                'assert_response' => [
                    'final_position' => '53x53',
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
