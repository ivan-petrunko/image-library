<?php

declare(strict_types=1);

namespace Tests\Petrunko\Image\Resizer;

use Petrunko\Image\Resizer\Resizer;
use Petrunko\Image\Resizer\ResizerInterface;
use Petrunko\Image\Resizer\ResizerOptions;
use Petrunko\Image\Size\Calculator\CalculatorInterface;
use Petrunko\Image\Size\Calculator\FitCalculator;
use Petrunko\Image\Size\Size;
use PHPUnit\Framework\TestCase;

class ResizerTest extends TestCase
{
    private ResizerInterface $resizer;
    private CalculatorInterface $fitCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resizer = new Resizer();
        $this->fitCalculator = new FitCalculator();
    }

    /**
     * @param string $sourceFilePath
     * @param Size $size
     * @param string $expectedMimeType
     * @dataProvider resizeProvider
     */
    public function testResize(string $sourceFilePath, Size $size, string $expectedMimeType): void
    {
        $destFilePath = __DIR__ . '/../../../stubs/resized';
        $this->resizer->resize(
            $sourceFilePath,
            $destFilePath,
            $this->fitCalculator,
            new ResizerOptions($size)
        );

        self::assertEquals($expectedMimeType, mime_content_type($destFilePath));

        [$width, $height] = getimagesize($destFilePath);
        self::assertLessThanOrEqual($size->getWidth(), $width);
        self::assertLessThanOrEqual($size->getHeight(), $height);

        unlink($destFilePath);
    }

    public static function resizeProvider(): \Generator
    {
        yield [
            __DIR__ . '/../../../stubs/1.jpg',
            new Size(320, 240),
            'image/jpeg',
        ];

        yield [
            __DIR__ . '/../../../stubs/2.png',
            new Size(320, 240),
            'image/png',
        ];

        yield [
            __DIR__ . '/../../../stubs/3.gif',
            new Size(320, 240),
            'image/gif',
        ];
    }
}
