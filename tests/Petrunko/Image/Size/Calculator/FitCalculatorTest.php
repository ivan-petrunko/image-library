<?php

declare(strict_types=1);

namespace Tests\Petrunko\Image\Size\Calculator;

use Petrunko\Image\Size\Calculator\CalculatorInterface;
use Petrunko\Image\Size\Calculator\FitCalculator;
use Petrunko\Image\Size\Size;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Petrunko\Image\Size\Calculator\FitCalculator::calculate
 */
class FitCalculatorTest extends TestCase
{
    private CalculatorInterface $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new FitCalculator();
    }

    /**
     * @param Size $source
     * @param Size $destination
     * @param Size $expected
     * @dataProvider calculateProvider
     */
    public function testCalculate(Size $source, Size $destination, Size $expected): void
    {
        $actual = $this->calculator->calculate($source, $destination);
        self::assertEquals($expected, $actual);
    }

    public static function calculateProvider(): \Generator
    {
        yield [
            new Size(1024, 768), // source
            new Size(320, 240),  // destination
            new Size(320, 240),  // result
        ];
        yield [
            new Size(1024, 768),
            new Size(320, 320),
            new Size(320, 240),
        ];
        yield [
            new Size(1024, 768),
            new Size(240, 320),
            new Size(240, 180),
        ];
        yield [
            new Size(768, 1024),
            new Size(240, 320),
            new Size(240, 320),
        ];
        yield [
            new Size(768, 1024),
            new Size(320, 320),
            new Size(240, 320),
        ];
        yield [
            new Size(768, 1024),
            new Size(320, 240),
            new Size(180, 240),
        ];
        yield [
            new Size(920, 800),
            new Size(320, 240),
            new Size(276, 240),
        ];
        yield [
            new Size(800, 920),
            new Size(240, 320),
            new Size(240, 276),
        ];
    }
}

