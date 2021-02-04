<?php

declare(strict_types=1);

namespace Tests\Petrunko\Image\Size\Calculator;

use Petrunko\Image\Size\Calculator\CalculatorInterface;
use Petrunko\Image\Size\Calculator\FillCalculator;
use Petrunko\Image\Size\Size;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Petrunko\Image\Size\Calculator\FillCalculator::calculate
 */
class FillCalculatorTest extends TestCase
{
    private CalculatorInterface $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new FillCalculator();
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

    public function calculateProvider(): \Generator
    {
        yield [
            new Size(1200, 913), // source
            new Size(320, 240),  // destination
            new Size(320, 243),  // result
        ];
        yield [
            new Size(1200, 600),
            new Size(320, 240),
            new Size(480, 240),
        ];
    }
}

