<?php

test('Decode Message', function (string $class, string $file) {
    $json = jsonFixture($file);
    $proto = protoFixture($file);

    $data = $class::decode($proto);

    expect(json_encode($data, JSON_PRETTY_PRINT))->toBe(json_encode($json, JSON_PRETTY_PRINT));
})->with([
    // Common
    [\Tests\php\pb\Common\Address::class, 'Address'],
    [\Tests\php\pb\Common\Coordinates::class, 'Coordinates'],
    [\Tests\php\pb\Common\Money::class, 'Money'],
    [\Tests\php\pb\Common\Timestamp::class, 'Timestamp'],
    //
    // Imports
    [\Tests\php\pb\Imports\User::class, 'User'],
    //
    // Repeated
    [\Tests\php\pb\Repeated\Organization::class, 'Organization'],
    //
    // Scalars
    [\Tests\php\pb\Scalars\Scalars::class, 'Scalars'],
    //
    // Map
    [\Tests\php\pb\Map\Map::class, 'Map'],
]);
