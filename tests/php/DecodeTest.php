<?php

test('Decode Message', function (string $class, string $file) {
    $json = jsonFixture($file);
    $proto = protoFixture($file);

    $data = $class::decode($proto);

    expect(json_encode($data, JSON_PRETTY_PRINT))->toBe(json_encode($json, JSON_PRETTY_PRINT));
})->with([
    // Common
    [\Tests\PB\Address::class, 'Address'],
    [\Tests\PB\Coordinates::class, 'Coordinates'],
    [\Tests\PB\Money::class, 'Money'],
    [\Tests\PB\Timestamp::class, 'Timestamp'],
    //
    // Imports
    [\Tests\PB\User::class, 'User'],
    //
    // Repeated
    [\Tests\PB\Organization::class, 'Organization'],
    //
    // Scalars
    [\Tests\PB\Scalars::class, 'Scalars'],
    //
    // Map
    [\Tests\PB\Map::class, 'Map'],
]);
