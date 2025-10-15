<?php

use Tests\PB\Order;

function jsonFixture(string $name): array
{
    return json_decode(file_get_contents(__DIR__ . '/../fixtures/' . $name . '.json'), true);
}

/**
 * @return int[]
 */
function protoFixture(string $name): array
{
    return array_values(unpack('C*', file_get_contents(__DIR__ . '/../fixtures/' . $name . '.bin')));
}

test('test', function () {
    $orderJson = jsonFixture('order');
    $orderProto = protoFixture('order');

    $order = Order::decode($orderProto);

    dd($order);
});
