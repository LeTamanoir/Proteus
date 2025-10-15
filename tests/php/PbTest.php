<?php

test('Decode Message', function (string $class, string $file) {
    $json = jsonFixture($file);
    $proto = protoFixture($file);

    $data = $class::decode($proto);

    expect(json_encode($data, JSON_PRETTY_PRINT))->toBe(json_encode($json, JSON_PRETTY_PRINT));
})->with([
    [\Tests\PB\Address::class, 'Address'],
    [\Tests\PB\Coordinates::class, 'Coordinates'],
    [\Tests\PB\Money::class, 'Money'],
    [\Tests\PB\Timestamp::class, 'Timestamp'],
]);
