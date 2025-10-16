<?php

require __DIR__ . '/../vendor/autoload.php';

function protoFixture(string $name): string
{
    return file_get_contents(__DIR__ . "/../tests/fixtures/{$name}.bin");
}

function benchmark(callable $callback, int $iterations = 1000): float
{
    $start = hrtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        $callback();
    }
    return ((hrtime(true) - $start) / 1_000_000) / $iterations;
}

function benchmarkProteus(string $file)
{
    $proto = protoFixture($file);

    $time = benchmark(function () use ($proto) {
        $data = \Tests\PB\benchmark\proteus\Bench::decode($proto);
    }, 100);
    dump('(Proteus) time: ' . $time . 'ms');
    expect(true)->toBeTrue();
}

function benchmarkGoogle(string $file)
{
    $proto = protoFixture($file);

    $time = benchmark(function () use ($proto) {
        $instance = new \Tests\php\pb\benchmark\google\Bench();
        $instance->mergeFromString($proto);
    }, 100);
    dump('(Google)  time: ' . $time . 'ms');
    expect(true)->toBeTrue();
}

benchmarkGoogle('Benchmark');
benchmarkProteus('Benchmark');
