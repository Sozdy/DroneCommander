<?php
use Symfony\Component\HttpFoundation\Response;

test('it should return drone final position and optimal way commands', function () {
    $body_request = [
        'commands' => 'up,up,down,right,left,up,right,up',
        'start_position' => '0x0',
        'has_walls' => true,
    ];

    $response = $this->postJson(route('drones.move'), $body_request);

    $response->assertJsonStructure([
        'final_position',
        'optimal_way',
    ]);
    $response->assertJsonFragment(["final_position"=> "1x3", "optimal_way" => "Right,Up,Up,Up"]);
    $response->assertStatus(Response::HTTP_CREATED);
});
