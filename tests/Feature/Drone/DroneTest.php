<?php
use Symfony\Component\HttpFoundation\Response;


describe('validate request data', function () {
    test('commands required', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => '',
                ],
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => null,
                ],
            ],
        ];

        foreach ($data as $case) {
            $response = $this->postJson(route('drones.move'), $case['body_request']);

            $response->assertJsonValidationErrors(['commands']);
            $response->assertJsonMissingValidationErrors(['start_position', 'has_walls']);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    });

    test('commands must be valid', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => 'InvalidCommand',
                ],
                'expected_message' => 'Invalid abbreviation "InvalidCommand". Abbreviation can be only "down, left, right, up"'
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => 'up,',
                ],
                'expected_message' => 'Invalid abbreviation "". Abbreviation can be only "down, left, right, up"'
            ],
        ];

        foreach ($data as $case) {
            $response = $this->postJson(route('drones.move'), $case['body_request']);

            $response->assertJsonFragment(['message' => $case['expected_message']]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    });

    test('start_position must be valid', function () {
        $data = [
            'case_1' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => '10',
                ],
                'expected_message' => 'Invalid string format "10". Example: 1x1 or 0x1'
            ],
            'case_2' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => '10x',
                ],
                'expected_message' => 'Invalid string format "10x". Example: 1x1 or 0x1'
            ],
            'case_3' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => 'x10',
                ],
                'expected_message' => 'Invalid string format "x10". Example: 1x1 or 0x1'
            ],
            'case_4' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => '10x10x10',
                ],
                'expected_message' => 'Invalid string format "10x10x10". Example: 1x1 or 0x1'
            ],
            'case_5' => [
                'body_request' => [
                    'commands' => 'up',
                    'start_position' => 'QxQ',
                ],
                'expected_message' => 'Invalid string format "QxQ". Example: 1x1 or 0x1'
            ],
        ];

        foreach ($data as $case) {
            $response = $this->postJson(route('drones.move'), $case['body_request']);

            $response->assertJsonFragment(['message' => $case['expected_message']]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    });
});

//describe('')
