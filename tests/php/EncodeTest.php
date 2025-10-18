<?php

test('Encode and Decode Round-Trip', function (string $class, string $file) {
    $proto = protoFixture($file);

    // Decode the original protobuf binary
    $decoded = $class::decode($proto);

    // Encode it back
    $encoded = $decoded->encode();

    // Decode the encoded data
    $decodedAgain = $class::decode($encoded);

    // Verify they match (comparing JSON ensures we check data, not byte-for-byte encoding)
    expect(json_encode($decodedAgain, JSON_PRETTY_PRINT))->toBe(json_encode($decoded, JSON_PRETTY_PRINT));
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
    [\Tests\php\pb\Scalars\Scalars::class, 'ScalarsMin'],
    //
    // Map
    [\Tests\php\pb\Map\Map::class, 'Map'],
    //
    // Nested
    [\Tests\php\pb\Nested\Nested::class, 'Nested'],
]);
